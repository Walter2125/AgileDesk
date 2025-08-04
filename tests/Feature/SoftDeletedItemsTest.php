<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Models\Historia;
use App\Models\Tarea;

class SoftDeletedItemsTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        // Crear usuario admin para las pruebas
        $this->admin = User::factory()->create([
            'usertype' => 'admin',
            'name' => 'Test Admin',
            'email' => 'admin@test.com'
        ]);
        
        // Crear usuario normal para las pruebas
        $this->user = User::factory()->create([
            'usertype' => 'user',
            'name' => 'Test User',
            'email' => 'user@test.com'
        ]);
    }

    /** @test */
    public function admin_can_view_soft_deleted_items()
    {
        $response = $this->actingAs($this->admin)
                        ->get(route('admin.soft-deleted'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.soft-deleted');
    }

    /** @test */
    public function non_admin_cannot_view_soft_deleted_items()
    {
        $response = $this->actingAs($this->user)
                        ->get(route('admin.soft-deleted'));

        $response->assertStatus(302);
        $response->assertRedirect(route('homeuser'));
        $response->assertSessionHas('persistent_error');
    }

    /** @test */
    public function guest_cannot_view_soft_deleted_items()
    {
        $response = $this->get(route('admin.soft-deleted'));

        $response->assertStatus(302); // Redirect to login
    }

    /** @test */
    public function soft_deleted_users_appear_in_list()
    {
        // Crear y eliminar un usuario
        $deletedUser = User::factory()->create([
            'usertype' => 'user',
            'name' => 'Deleted User'
        ]);
        $deletedUser->delete();

        $response = $this->actingAs($this->admin)
                        ->get(route('admin.soft-deleted'));

        $response->assertStatus(200);
        $response->assertSee('Deleted User');
        $response->assertSee('Usuario');
    }

    /** @test */
    public function admin_can_restore_soft_deleted_item()
    {
        // Crear y eliminar un usuario
        $deletedUser = User::factory()->create([
            'usertype' => 'user',
            'name' => 'User to Restore'
        ]);
        $deletedUser->delete();

        // Restaurar el usuario
        $response = $this->actingAs($this->admin)
                        ->post(route('admin.soft-deleted.restore', ['model' => 'users', 'id' => $deletedUser->id]));

        $response->assertStatus(302);
        $response->assertSessionHas('success');
        
        // Verificar que el usuario fue restaurado
        $this->assertDatabaseHas('users', [
            'id' => $deletedUser->id,
            'deleted_at' => null
        ]);
    }

    /** @test */
    public function admin_can_permanently_delete_item()
    {
        // Crear y eliminar un usuario
        $deletedUser = User::factory()->create([
            'usertype' => 'user',
            'name' => 'User to Delete'
        ]);
        $deletedUser->delete();

        // Eliminar permanentemente
        $response = $this->actingAs($this->admin)
                        ->delete(route('admin.soft-deleted.permanent-delete', ['model' => 'users', 'id' => $deletedUser->id]));

        $response->assertStatus(302);
        $response->assertSessionHas('success');
        
        // Verificar que el usuario fue eliminado permanentemente
        $this->assertDatabaseMissing('users', [
            'id' => $deletedUser->id
        ]);
    }

    /** @test */
    public function filters_work_correctly()
    {
        // Crear y eliminar diferentes tipos de elementos
        $deletedUser = User::factory()->create(['usertype' => 'user', 'name' => 'Test User']);
        $deletedUser->delete();

        // Filtrar solo usuarios
        $response = $this->actingAs($this->admin)
                        ->get(route('admin.soft-deleted', ['type' => 'users']));

        $response->assertStatus(200);
        $response->assertSee('Test User');
    }

    /** @test */
    public function search_filter_works()
    {
        // Crear y eliminar un usuario con nombre específico
        $deletedUser = User::factory()->create([
            'usertype' => 'user', 
            'name' => 'Searchable User'
        ]);
        $deletedUser->delete();

        // Buscar por nombre
        $response = $this->actingAs($this->admin)
                        ->get(route('admin.soft-deleted', ['search' => 'Searchable']));

        $response->assertStatus(200);
        $response->assertSee('Searchable User');
    }
}

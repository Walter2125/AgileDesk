<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        User::factory()->create([
            'name' => 'son',
            'email' => 'tost@example.com',
            'usertype' => 'user',
        ]);

        User::factory()->create([
            'name' => 'kane',
            'email' => 'best@example.com',
            'usertype' => 'user',
        ]);
        
        $this->call(AdminUserSeeder::class);

    }
}

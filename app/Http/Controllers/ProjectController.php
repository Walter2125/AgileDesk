<?php

namespace App\Http\Controllers;

use App\Models\Columna;
use App\Models\Project;
use App\Models\User;
use App\Models\Notificaciones;
use App\Models\Tablero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProjectController extends Controller
{

    public function create(Request $request)
    {
        $users = User::where('usertype', '!=', 'admin')
            ->where('is_approved', true)
            ->where('is_rejected', false)
            ->paginate(5)
            ->withPath(route('projects.listUsers'));

        $selectedUsers = [];

        return view('projects.create', compact('users', 'selectedUsers'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:nuevo_proyecto,name|max:50',
            'descripcion' => 'nullable|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date|after_or_equal:fecha_inicio',
            'selected_users' => 'required|array|min:1',
        ]);

        try {
            DB::beginTransaction();

            // Generar código único de 5 caracteres
            $codigo = Project::generarCodigo(5);

            // Crear proyecto
            $project = Project::create([
                'name' => $request->name,
                'codigo' => $codigo,
                'descripcion'  => $request->descripcion,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin'    => $request->fecha_fin,
                'user_id'      => Auth::id(),
            ]);


            $project->users()->sync(array_unique(array_merge(
                [Auth::id()],
            $request->input('selected_users', [])
            )));

            //creacion de proyecto
            $tablero = Tablero::create([
                'proyecto_id' => $project->id,
            ]);

            // Crear columna Backlog vinculada al tablero
            $tablero->columnas()->create([
                'nombre' => 'Pendiente',
                'posicion' => 1,
                'es_backlog' => true,
            ]);

            $tablero = Tablero::create([
            'proyecto_id' => $project->id,
           ]);

            $tablero->columnas()->create([
                'nombre' => 'Backlog',
                'posicion' => 1,
                'es_backlog' => true,
            ]);

            DB::commit();

            return redirect()->route('projects.my')->with('success', 'Proyecto creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al crear el proyecto: ' . $e->getMessage());
        }

    }

    public function searchUsers(Request $request)
    {
        $query = $request->input('query');

        $users = User::where('name', 'like', "%{$query}%")
            ->where('usertype', '!=', 'admin')
            ->where('is_approved', true)
            ->where('is_rejected', false)
            ->where('id', '!=', Auth::id())
            ->get(['id', 'name', 'email']);

        return response()->json($users);
    }


    public function index()
    {
        $nuevo_proyecto = Project::with('users')->orderBy('created_at', 'desc')->get();

        return view('projects.create', compact('nuevo_proyecto'));
    }

    public function myProjects()
    {
        $user = Auth::user();
        $projects = $user->projects->sortByDesc('created_at');
        return view('projects.myprojects', compact('projects'));
    }


    public function edit($id)
    {
        $project = Project::with('users')->findOrFail($id);

        if (Auth::id() !== $project->user_id) {
            return redirect()->route('projects.my')->with('error', 'No tienes permiso para editar este proyecto.');
        }

        $users = User::where('usertype', '!=', 'admin')
            ->where('is_approved', true)
            ->where('is_rejected', false)
            ->where('id', '!=', $project->user_id)
            ->paginate(5)
            ->withPath(route('projects.listUsers'));

        $selectedUsers = $project->users->pluck('id')->toArray();

        return view('projects.edit', compact('project', 'users', 'selectedUsers'));
    }


    public function update(Request $request, $id)
    {
        // Validación de datos
        $request->validate([
            'name' => 'required|max:30|unique:nuevo_proyecto,name,' . $id,
            'descripcion' => 'nullable|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'users' => 'required|array|min:1', 
            'users.*' => 'exists:users,id', // Aseguramos que todos los usuarios seleccionados existen
        ]);

        // Buscar el proyecto a actualizar
        $project = Project::findOrFail($id);

        // Verificar si el usuario logueado es el propietario del proyecto
        if (Auth::id() !== $project->user_id) {
            return redirect()->route('projects.my')->with('error', 'No tienes permiso para editar este proyecto.');
        }

        // Actualizar el proyecto
        $project->update([
            'name' => $request->name,
            'descripcion' => $request->descripcion,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
        ]);

        // Agregar el creador del proyecto a la lista de usuarios, si no está ya en la lista
        $users = $request->users;
        if (!in_array($project->user_id, $users)) {
            $users[] = $project->user_id; // Aseguramos que el creador siempre esté incluido
        }

        // Sincronizar los usuarios asignados al proyecto, asegurando que el creador siempre esté incluido
        $project->users()->sync($users);

        return redirect()->route('projects.my')->with('success', 'Proyecto actualizado exitosamente.');
    }



    public function removeUser($projectId, $userId)
    {
        $project = Project::findOrFail($projectId);
        $user = User::findOrFail($userId);

        if ($project->users->contains($user)) {
            $project->users()->detach($user);
            return response()->json(['success' => 'Usuario eliminado exitosamente'], 200);
        }

        return response()->json(['error' => 'El usuario no está asociado a este proyecto'], 404);
    }

    public function destroy(Request $request, $id)
    {
    $project = Project::find($id);

    if (!$project) {
        return $request->expectsJson()
            ? response()->json(['error' => 'Proyecto no encontrado.'], 404)
            : redirect()->route('projects.my')->with('error', 'Proyecto no encontrado.');
    }

    if (Auth::user()->usertype != 'admin') {
        return $request->expectsJson()
            ? response()->json(['error' => 'No tienes permiso para eliminar este proyecto.'], 403)
            : redirect()->route('projects.my')->with('error', 'No tienes permiso.');
    }

    try {
        $project->delete();

        return $request->expectsJson()
            ? response()->json(['message' => 'Proyecto eliminado exitosamente.'])
            : redirect()->route('projects.my')->with('success', 'Proyecto eliminado exitosamente.');
    } catch (\Exception $e) {
        return $request->expectsJson()
            ? response()->json(['error' => 'Error al eliminar el proyecto: ' . $e->getMessage()], 500)
            : redirect()->route('projects.my')->with('error', 'Error al eliminar el proyecto.');
    }
    }


    public function listUsers(Request $request)
    {
        $users = User::where('usertype', '!=', 'admin')
            ->where('is_approved', true)
            ->where('is_rejected', false)
            ->paginate(5)
            ->withPath(route('projects.listUsers')); // <--- Esto es clave

        $selectedUsers = $request->input('selected_users', []);

        if ($request->ajax()) {
            $html = view('projects.partials.users_table', [
                'users' => $users,
                'selectedUsers' => $selectedUsers
            ])->render();

            $pagination = view('projects.partials.pagination_links', ['users' => $users])->render();

            return response()->json([
                'html' => $html,
                'pagination' => $pagination,
            ]);
        }

        return view('projects.create', compact('users', 'selectedUsers'));
    }

}

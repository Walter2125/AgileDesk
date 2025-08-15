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
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;


class ProjectController extends Controller
{
    use AuthorizesRequests;

    public function create(Request $request)
    {
        $users = User::where(function($query) {
        $query->where('is_approved', true)
              ->where('is_rejected', false);
    })
    ->orWhere('usertype', 'superadmin', 'admin') // incluye superadmin aunque no esté aprobado
    ->paginate(5)
    ->withPath(route('projects.listUsers'));

        $selectedUsers = [];

        return view('projects.create', compact('users', 'selectedUsers'));
    }


   public function store(Request $request)
{
    $rules = [
        'name' => [
            'required',
            'max:50',
            'regex:/^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ]+$/',
            Rule::unique('nuevo_proyecto', 'name'),
        
        ],
        'codigo' => [
            'required',
            'string',
            'max:6',
            Rule::unique('nuevo_proyecto', 'codigo'),
            'regex:/^[a-zA-Z0-9]+$/'
        ],
        'descripcion' => [
            'nullable',
            'string',
            'max:255',
            'regex:/^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ.,;:()\-]+$/'
        ],
        'fecha_inicio' => 'required|date',
        'fecha_fin'    => 'required|date|after_or_equal:fecha_inicio',
        'selected_users' => 'required|array|min:1',
    ];

    $messages = [
        'name.required' => 'El nombre del proyecto es obligatorio.',
        'name.unique'   => 'El nombre del proyecto ya existe.',
        'name.max'      => 'El nombre del proyecto no puede superar :max caracteres.',
        'codigo.required' => 'El código del proyecto es obligatorio.',
        'codigo.unique'   => 'El código del proyecto ya existe.',
        'codigo.regex' => 'El código del proyecto solo puede contener letras y números, sin espacios ni caracteres especiales.',
        'descripcion.max' => 'La descripción no puede superar :max caracteres.',
        'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
        'fecha_fin.required' => 'La fecha de finalización es obligatoria.',
        'fecha_fin.after_or_equal' => 'La fecha de finalización debe ser igual o posterior a la fecha de inicio.',
        'selected_users.required' => 'Debe seleccionar al menos un usuario.',
        'selected_users.min' => 'Debe seleccionar al menos un usuario.',
    ];

    $attributes = [
        'name' => 'nombre del proyecto',
        'codigo' => 'código del proyecto',
        'descripcion' => 'descripción',
        'fecha_inicio' => 'fecha de inicio',
        'fecha_fin' => 'fecha de finalización',
        'selected_users' => 'usuarios seleccionados',
    ];

    $request->validate($rules, $messages, $attributes);

    try {
        DB::beginTransaction();

        // Crear el proyecto
        $project = Project::create([
            'name' => $request->name,
            'codigo' => $request->codigo,
            'descripcion' => $request->descripcion,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'user_id' => Auth::id(),
        ]);

        // Asociar usuarios (incluyendo al creador)
        $project->users()->sync(array_unique(array_merge(
            [Auth::id()],
            $request->input('selected_users', [])
        )));

        // Crear tablero y columnas iniciales
        $tablero = Tablero::create([
            'proyecto_id' => $project->id,
        ]);

        $tablero->columnas()->createMany([
            [
                'nombre' => 'Pendiente',
                'posicion' => 1,
                'es_backlog' => true,
            ],

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
            ->whereNotIn('usertype', true)
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

    // Superadmin puede ver todos los proyectos, admin solo los suyos
    if ($user->isSuperAdmin()) {
        $projects = Project::with(['tareas', 'historias', 'sprints', 'creator', 'users'])->get();
    } else {
        $projects = $user->projects()->with(['tareas', 'historias', 'sprints'])->get();
    }

    $sorted = $projects->sortByDesc(function ($project) {
        return max([
            optional($project->tareas->max('updated_at')),
            optional($project->historias->max('updated_at')),
            optional($project->sprints->max('updated_at')),
            $project->updated_at,
        ]);
    });

    $recentProjects = $sorted->take(3);
    $allProjects = $sorted;

    return view('projects.myprojects', compact('recentProjects', 'allProjects'));
}



    public function edit($id)
    {
        $project = Project::with('users')->findOrFail($id);

        // Superadmin puede editar cualquier proyecto, admin solo sus propios proyectos
        if (!Auth::user()->isSuperAdmin() && Auth::id() !== $project->user_id) {
            return redirect()->route('projects.my')->with('error', 'No tienes permiso para editar este proyecto.');
        }

        $users = User::where('usertype', true)
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
        $project = Project::findOrFail($id);

        $request->validate([
            'name' => [
        'required',
        'max:50',
        'unique:nuevo_proyecto,name,' . $id,
        'regex:/^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ]+$/'
    ],
             'codigo' => [
        'required',
        'max:6',
        'unique:nuevo_proyecto,codigo,' . $project->id,
        'regex:/^[a-zA-Z0-9]+$/'
    ],
           'descripcion' => [
        'nullable',
        'string',
        'max:255',
        'regex:/^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ.,;:()\-]+$/'
    ],
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'users' => 'required|array|min:1',
            'users.*' => 'exists:users,id',
        ]);


        // Superadmin puede editar cualquier proyecto, admin solo sus propios proyectos
        if (!Auth::user()->isSuperAdmin() && Auth::id() !== $project->user_id) {
            return redirect()->route('projects.my')->with('error', 'No tienes permiso para editar este proyecto.');
        }


        $project->update([
            'name' => $request->name,
            'codigo' => $request->codigo,
            'descripcion' => $request->descripcion,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
        ]);

        $users = $request->users;
        if (!in_array($project->user_id, $users)) {
            $users[] = $project->user_id;
        }

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

    // Superadmin puede eliminar cualquier proyecto, admin solo puede eliminar si es el dueño
    $canDelete = Auth::user()->isSuperAdmin() || 
                 (Auth::user()->usertype == 'admin' && Auth::id() === $project->user_id);

    if (!$canDelete) {
        return $request->expectsJson()
            ? response()->json(['error' => 'No tienes permiso para eliminar este proyecto.'], 403)
            : redirect()->route('projects.my')->with('error', 'No tienes permiso para eliminar este proyecto.');
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
        $users = User::where(function($query) {
        $query->where('is_approved', true)
              ->where('is_rejected', false);
    })
    ->orWhere('usertype', 'superadmin', 'admin') // incluye superadmin aunque no esté aprobado
    ->paginate(5)
    ->withPath(route('projects.listUsers'));


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

    public function cambiarColor(Request $request, Project $project)
    {
        if (Auth::id() !== $project->user_id) {
            return response()->json(['error' => 'No tienes permiso para cambiar el color.'], 403);
        }

        $request->validate([
            'color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/']
        ]);

        $project->color = $request->color;
        $project->save();

        return response()->json(['success' => true, 'color' => $project->color]);
    }

}

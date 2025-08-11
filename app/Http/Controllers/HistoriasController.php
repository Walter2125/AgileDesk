<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sprint;
use App\Models\Columna;
use App\Models\Project;
use App\Models\Tablero;
use App\Models\Historia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Models\HistorialCambio;
use Illuminate\Support\Facades\Auth;


class HistoriasController extends Controller
{

    private function cargarTableroDesdeHistoria(Historia $historia)
{
    $historia->load('columna.tablero.project');
        $tablero = $historia->columna?->tablero;
        View::share('tablero', $tablero);
        return $tablero;
}
private function compartirContextoDesdeColumna(Columna $columna)
{
    $tablero = $columna->tablero;
    View::share('tablero', $tablero);
}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $historias = Historia::all();

        return view('historias.index', compact('historias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createFromColumna($columnaId)
    {
        $columna = Columna::with('tablero.proyecto')->findOrFail($columnaId);
        $this->compartirContextoDesdeColumna($columna);

        $tablero = $columna->tablero;
        $proyecto = $tablero->proyecto;

        $usuarios = $proyecto->users()->where('usertype', '!=', 'admin')->get();
        $sprints = Sprint::where('proyecto_id', $proyecto->id)->get();
        $columnas = $tablero->columnas; // todas las columnas del tablero

        return view('historias.create', compact('columna', 'tablero', 'proyecto', 'usuarios', 'sprints', 'columnas'));
    }


    public function create(Request $request)
    {
        $proyecto = null;
        $columna = null;
        $usuarios = collect(); // por defecto vacío
        $sprints = collect();  // por defecto vacío
        $columnas = collect(); // columnas también
        $currentProject = $proyecto;

        if ($request->has('proyecto')) {
            $proyecto = Project::with('tablero.columnas')->find($request->get('proyecto'));

            if ($proyecto) {
                $usuarios = $proyecto->users()->where('usertype', '!=', 'admin')->get();
                $sprints = Sprint::where('proyecto_id', $proyecto->id)->get();


                if ($proyecto->tablero) {
                    $columnas = $proyecto->tablero->columnas;
                }

            }
        }

        return view('historias.create', compact('proyecto', 'columna', 'usuarios', 'sprints', 'columnas', 'currentProject'));

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'nombre' => [
            'required', 'string', 'min:3', 'max:100',
            Rule::unique('historias')->where(function ($query) use ($request) {
                return $query->where('proyecto_id', $request->proyecto_id);
            }),
        ],
        'trabajo_estimado' => 'nullable|integer|min:0',
        'prioridad' => 'required|in:Alta,Media,Baja',
        'descripcion' => 'nullable|string|max:5000',
        'proyecto_id' => 'required|exists:nuevo_proyecto,id',
        'columna_id' => 'nullable|exists:columnas,id',
        'tablero_id' => 'exists:tableros,id',
        'usuario_id' => 'nullable|exists:users,id',
        'sprint_id' => 'nullable|exists:sprints,id',
    ], [
        'nombre.required' => 'El nombre es obligatorio.',
        'nombre.min' => 'El nombre debe tener al menos :min caracteres.',
        'nombre.max' => 'El nombre no puede exceder los :max caracteres.',
        'nombre.unique' => 'El nombre ya existe, por favor elige otro.',
        'trabajo_estimado.integer' => 'El trabajo estimado debe ser un número entero.',
        'trabajo_estimado.min' => 'El trabajo estimado no puede ser negativo.',
        'prioridad.required' => 'Debe seleccionar una prioridad.',
        'prioridad.in' => 'La prioridad debe ser Alta, Media o Baja.',
    ]);

    $columna = null;
    if ($request->columna_id) {
        $columna = Columna::with('tablero')->findOrFail($request->columna_id);
    }

    $historia = new Historia();
    $historia->nombre = $request->nombre;
    $historia->trabajo_estimado = $request->trabajo_estimado;
    $historia->prioridad = $request->prioridad;
    $historia->descripcion = $request->descripcion;
    $historia->proyecto_id = $request->proyecto_id;
    $historia->columna_id = $request->columna_id;
    $historia->tablero_id = $request->tablero_id;
    $historia->usuario_id = $request->usuario_id;
    $historia->sprint_id = $request->sprint_id;

    // Solución: Generar un código único
    $historia->codigo = 'H-' . uniqid();

    $historia->save();

    HistorialCambio::create([
        'fecha' => now(),
        'usuario' => Auth::user()->name,
        'accion' => 'Creación de Historia',
        'detalles' => 'Historia "' . $historia->nombre . '" creada',
        'sprint' => $historia->sprint_id,
        'proyecto_id' => $historia->proyecto_id
    ]);

    return redirect()->route('tableros.show', ['project' => $historia->proyecto_id])
                     ->with('success', 'Historia creada con éxito');
}


    protected function obtenerProjectIdDeOtraForma(Historia $historia)
    {
        // Aquí tienes que definir cómo obtener el project_id cuando la historia no tiene columna.

        // Algunas ideas:
        // 1. Si tienes un campo 'project_id' en la tabla historias:
        if (isset($historia->proyecto_id)) {
            return $historia->proyecto_id;
        }

        // 2. Si puedes obtenerlo por otra relación o lógica, implementa aquí esa lógica.

        // 3. Si no tienes forma, puedes devolver null o lanzar un error controlado:
        return null;
    }

    /**
     * Display the specified resource.
     */
 public function show(Historia $historia)
{
    $historia->load('usuario', 'sprints', 'columna.tablero.project', 'proyecto');

    $currentProject = $historia->columna->tablero->project ?? $historia->proyecto;

    $tareas = $historia->tareas()->with('user')->get();

    // Obtener las columnas para el select
    $columnas = collect(); // valor por defecto vacío
    if ($historia->columna && $historia->columna->tablero) {
        $columnas = $historia->columna->tablero->columnas;
    } else if ($currentProject->tablero) {
        $columnas = $currentProject->tablero->columnas;
    }

    // Agregar usuarios y sprints para los selects en la vista
    $usuarios = User::all();

    $sprints = Sprint::all();

    return view('historias.show', compact('historia', 'currentProject', 'tareas', 'columnas', 'usuarios', 'sprints'));
}





    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $historia = Historia::with(['proyecto', 'usuario', 'columna.tablero'])->findOrFail($id);
        $this->cargarTableroDesdeHistoria($historia);
        $proyecto = $historia->proyecto;
        $usuarios = $proyecto->users()->where('usertype', '!=', 'admin')->get();
        $sprints = Sprint::where('proyecto_id', $proyecto->id)->get();
        View::share('currentProject', $proyecto);


        // Obtener columnas desde el tablero si existe, sino vacío
        if ($historia->columna && $historia->columna->tablero) {
            $columnas = $historia->columna->tablero->columnas;
        } else {
            // Buscar tablero del proyecto
            $tablero = $proyecto->tablero()->with('columnas')->first();
            $columnas = $tablero ? $tablero->columnas : collect();
        }

        return view('historias.edit', compact('historia', 'usuarios', 'sprints', 'columnas', 'proyecto'));

    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Historia $historia)
{
    // Guardar valores antiguos para el historial
    $valoresAntiguos = [
        'nombre' => $historia->nombre,
        'trabajo_estimado' => $historia->trabajo_estimado,
        'prioridad' => $historia->prioridad,
        'descripcion' => $historia->descripcion,
        'usuario_id' => $historia->usuario_id,
        'sprint_id' => $historia->sprint_id,
        'columna_id' => $historia->columna_id
    ];

    $request->validate([
        'nombre' => ['required','string','min:3','max:255',
            Rule::unique('historias')
                ->where(function ($query) use ($request) {
                    return $query->where('proyecto_id', $request->proyecto_id);
                })
                ->ignore($historia->id),
        ],
        'trabajo_estimado' => 'nullable|integer|min:0',
        'prioridad' => 'required|in:Alta,Media,Baja',
        'descripcion' => 'nullable|string|max:5000',
        'usuario_id' => 'nullable|exists:users,id',
        'sprint_id' => 'nullable|exists:sprints,id',
        'columna_id' => 'nullable|exists:columnas,id',
    ], [
        // ... (mensajes de validación existentes)
    ]);

    // Actualizar la historia
    $historia->update([
        'nombre' => $request->nombre,
        'trabajo_estimado' => $request->trabajo_estimado,
        'prioridad' => $request->prioridad,
        'descripcion' => $request->descripcion,
        'usuario_id' => $request->usuario_id,
        'sprint_id' => $request->sprint_id,
        'columna_id' => $request->columna_id,
    ]);

    // Obtener nombres de usuarios y columnas para el historial
    $usuarioAntiguo = $valoresAntiguos['usuario_id'] ? User::find($valoresAntiguos['usuario_id'])->name : 'Sin asignar';
    $usuarioNuevo = $request->usuario_id ? User::find($request->usuario_id)->name : 'Sin asignar';
    $columnaAntigua = Columna::find($valoresAntiguos['columna_id'])->nombre;
    $columnaNueva = Columna::find($request->columna_id)->nombre;

    // Registrar en el historial
    HistorialCambio::create([
        'fecha' => now(),
        'usuario' => Auth::user()->name,
        'accion' => 'Edición de Historia',
        'detalles' => $this->generarDetallesCambios([
            'nombre' => $valoresAntiguos['nombre'],
            'trabajo_estimado' => $valoresAntiguos['trabajo_estimado'],
            'prioridad' => $valoresAntiguos['prioridad'],
            'usuario' => $usuarioAntiguo,
            'columna' => $columnaAntigua
        ], [
            'nombre' => $request->nombre,
            'trabajo_estimado' => $request->trabajo_estimado,
            'prioridad' => $request->prioridad,
            'usuario' => $usuarioNuevo,
            'columna' => $columnaNueva
        ]),
        'sprint' => $historia->sprint_id,
        'proyecto_id' => $historia->proyecto_id
    ]);

    return redirect()->route('historias.show', $historia->id)
        ->with('success', 'Historia editada con éxito');
}
    private function generarDetallesCambios($antes, $despues)
{
    $cambios = [];

    if ($antes['nombre'] != $despues['nombre']) {
        $cambios[] = sprintf('Nombre: "%s" → "%s"', $antes['nombre'], $despues['nombre']);
    }

    if ($antes['trabajo_estimado'] != $despues['trabajo_estimado']) {
        $cambios[] = sprintf('Trabajo estimado: %d → %d',
            $antes['trabajo_estimado'] ?? 0,
            $despues['trabajo_estimado'] ?? 0);
    }

    if ($antes['prioridad'] != $despues['prioridad']) {
        $cambios[] = sprintf('Prioridad: %s → %s', $antes['prioridad'], $despues['prioridad']);
    }

    if ($antes['usuario'] != $despues['usuario']) {
        $cambios[] = sprintf('Asignado: %s → %s', $antes['usuario'], $despues['usuario']);
    }

    if ($antes['columna'] != $despues['columna']) {
        $cambios[] = sprintf('Columna: %s → %s', $antes['columna'], $despues['columna']);
    }

    return $cambios ? implode(', ', $cambios) : 'Sin cambios detectados';
}



   public function destroy(Historia $historia)
        {
            HistorialCambio::create([
                'fecha' => now(),
                'usuario' => Auth::user()->name,
                'accion' => 'Eliminación de Historia',
                'detalles' => sprintf(
                'Historia "%s" (ID: %d) eliminada por %s',
            $historia->nombre,
            $historia->id,
            Auth::user()->name
            ),
                'sprint' => $historia->sprint_id,
                'proyecto_id' => $historia->proyecto_id
            ]);

            $proyectoId = $historia->proyecto_id; // Guardas el ID antes de eliminar

            $historia->delete(); // Eliminas la historia

            return redirect()->route('tableros.show', ['project' => $proyectoId])
                            ->with('success', 'Historia borrada con éxito');
        }



    public function mover(Request $request, $id)
    {
        try {
            // Validar entrada
            $validated = $request->validate([
                'columna_id' => 'required|integer|exists:columnas,id'
            ]);

            // Obtener la historia
            $historia = Historia::findOrFail($id);

            // Verificar que la columna destino pertenece al mismo tablero
            $columnaDestino = Columna::findOrFail($validated['columna_id']);
            if ($historia->columna->tablero_id !== $columnaDestino->tablero_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'No puedes mover historias entre tableros diferentes'
                ], 403);
            }

            // Registrar en el historial antes de mover
            $columnaOrigen = $historia->columna;

            HistorialCambio::create([
                'fecha' => now(),
                'usuario' => Auth::user()->name,
                'accion' => 'Movimiento de Historia',
                'detalles' => sprintf(
                    'Historia "%s" movida de %s a %s',
                    $historia->nombre,
                    $columnaOrigen->nombre,
                    $columnaDestino->nombre
                ),
                'sprint' => $historia->sprint_id,
                'proyecto_id' => $historia->proyecto_id
            ]);

            // Actualizar y guardar
            $historia->columna_id = $validated['columna_id'];
            $historia->save();

            return response()->json([
                'success' => true,
                'message' => 'Historia movida correctamente',
                'data' => [
                    'historia_id' => $historia->id,
                    'nueva_columna_id' => $historia->columna_id,
                    'nueva_columna_nombre' => $columnaDestino->nombre
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al mover la historia: ' . $e->getMessage()
            ], 500);
        }
    }
}




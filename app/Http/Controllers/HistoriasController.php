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

    public function store(Request $request)
    {
        $request -> validate([
            'nombre' => ['required','string','min:3','max:100',
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

        ],
        [   'nombre.required' => 'El nombre es obligatorio.',
            'nombre.min' => 'El nombre debe tener al menos :min caracteres.',
            'nombre.max' => 'El nombre no puede exceder los :max caracteres.',
             'nombre.unique' => 'El nombre ya existe, por favor elige otro.',

            'trabajo_estimado.integer' => 'El trabajo estimado debe ser un número entero.',
            'trabajo_estimado.min' => 'El trabajo estimado no puede ser negativo.',

            'prioridad.required' => 'Debe seleccionar una prioridad.',
            'prioridad.in' => 'La prioridad debe ser Alta, Media o Baja.',
        ]);



        // Obtener el proyecto
        $proyecto = Project::findOrFail($request->proyecto_id);

        // Contar cuántas historias ya tiene este proyecto
        $numeroHistoria = Historia::where('proyecto_id', $proyecto->id)->count() + 1;

        // Crear código como PROY01-H1
        $codigoHistoria = $proyecto->codigo . '-H' . $numeroHistoria;

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

        // Asignar el código generado
        $historia->codigo = $codigoHistoria;

        $historia->save();

        return redirect()->route('tableros.show', ['project' => $historia->proyecto_id])
                 ->with('success', 'Historia creada con código ' . $codigoHistoria);

    }

    protected function obtenerProjectIdDeOtraForma(Historia $historia)
    {
        if (isset($historia->proyecto_id)) {
            return $historia->proyecto_id;
        }

        return null;
    }


    /**
     * Display the specified resource.
     */
    public function show(Historia $historia)
    {
        // Cargamos también la relación con el proyecto
        $historia->load('usuario', 'sprints', 'columna.tablero.project', 'proyecto');

        // Obtener el proyecto desde la columna o desde el propio campo proyecto_id
        $currentProject = $historia->columna->tablero->project
            ?? $historia->proyecto;

        return view('historias.show', compact('historia', 'currentProject'));
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
        $request->validate([
            'nombre' => [ 'required','string','min:3','max:255',
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
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.min' => 'El nombre debe tener al menos :min caracteres.',
            'nombre.max' => 'El nombre no puede exceder los :max caracteres.',
            'nombre.unique' => 'El nombre ya existe, por favor elige otro.',
            'trabajo_estimado.integer' => 'El trabajo estimado debe ser un número entero.',
            'trabajo_estimado.min' => 'El trabajo estimado no puede ser negativo.',
            'prioridad.required' => 'Debe seleccionar una prioridad.',
            'prioridad.in' => 'La prioridad debe ser Alta, Media o Baja.',
            'columna_id.exists' => 'La columna seleccionada no existe.',
        ]);

        $historia->update([
            'nombre' => $request->nombre,
            'trabajo_estimado' => $request->trabajo_estimado,
            'prioridad' => $request->prioridad,
            'descripcion' => $request->descripcion,
            'usuario_id' => $request->usuario_id,
            'sprint_id' => $request->sprint_id,
            'columna_id' => $request->columna_id, // ← TAMBIÉN FALTABA ESTO
        ]);

        return redirect()->route('historias.show', $historia->id)
            ->with('success', 'Historia editada con éxito');
    }

   public function destroy(Historia $historia)
        {
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
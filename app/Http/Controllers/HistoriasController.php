<?php

namespace App\Http\Controllers;

use App\Models\Columna;
use App\Models\Historia;
use Illuminate\Http\Request;
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

    return view('historias.create', compact('columna', 'tablero', 'proyecto','usuarios'));
}
 
    public function create()
    {
        return view('historias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate([
            'nombre'=> 'required|string|min:3|max:255|unique:historias,nombre',
            'trabajo_estimado' => 'nullable|integer|min:0',
            'prioridad' => 'required|in:Alta,Media,Baja',
            'descripcion' => 'nullable|string|max:1000',
             'proyecto_id' => 'required|exists:nuevo_proyecto,id',
            'columna_id' => 'exists:columnas,id',
            'tablero_id' => 'exists:tableros,id',
               'usuario_id' => 'nullable|exists:users,id',
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
        $columna = Columna::with('tablero')->findOrFail($request->columna_id);
        $historia = new Historia();
        $historia->nombre = $request->nombre;
        $historia->trabajo_estimado = $request->trabajo_estimado;
        $historia->prioridad = $request->prioridad;
        $historia->descripcion = $request->descripcion;
        $historia->proyecto_id = $request->proyecto_id;
        $historia->columna_id = $request->columna_id;
        $historia->tablero_id = $columna->tablero_id; // <- ahora se asigna automáticamente
        $historia->usuario_id = $request->usuario_id;
        $historia->save();

        
    return redirect()->route('tableros.show', ['project' => $historia->proyecto_id])
                     ->with('success', 'Historia creada con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(Historia $historia)
    {
        $tablero = $this->cargarTableroDesdeHistoria($historia);
        $historia->load('usuario');
        return view('historias.show',compact('historia'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $historia = Historia::with(['proyecto', 'usuario'])->findOrFail($id);
    $this->cargarTableroDesdeHistoria($historia);
    $proyecto = $historia->proyecto;
    $usuarios = $proyecto->users()->where('usertype', '!=', 'admin')->get();

    return view('historias.edit', compact('historia', 'usuarios'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Historia $historia)
{
    $request->validate([
         'nombre'=> 'required|string|min:3|max:255|unique:historias,nombre',
        'trabajo_estimado' => 'nullable|integer|min:0',
        'prioridad' => 'required|in:Alta,Media,Baja',
        'descripcion' => 'nullable|string|max:1000',
        'usuario_id' => 'nullable|exists:users,id',  // si para asignar usuario
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

    // Actualizar con un solo update
    $historia->update([
        'nombre' => $request->nombre,
        'trabajo_estimado' => $request->trabajo_estimado,
        'prioridad' => $request->prioridad,
        'descripcion' => $request->descripcion,
        'usuario_id' => $request->usuario_id, // si tienes este campo en historias
    ]);

    // Redirigir a la vista show pasando el ID
    return redirect()->route('historias.show', $historia->id)
                     ->with('success', 'Historia editada con éxito');
}


    /**
     * Remove the specified resource from storage.
     */
   public function destroy(Historia $historia)
        {
            $proyectoId = $historia->proyecto_id; // Guardas el ID antes de eliminar

            $historia->delete(); // Eliminas la historia

            return redirect()->route('tableros.show', ['project' => $proyectoId])
                            ->with('success', 'Historia borrada con éxito');
        }
}

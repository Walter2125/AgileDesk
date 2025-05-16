<?php

namespace App\Http\Controllers;

use App\Models\Historia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HistoriasController extends Controller
{
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
            'nombre'=> 'required|string|min:3|max:255',
            'trabajo_estimado' => 'nullable|integer|min:0',
            'prioridad' => 'required|in:Alta,Media,Baja',
            'descripcion' => 'nullable|string|max:1000',
        ],
[   'nombre.required' => 'El nombre es obligatorio.',
            'nombre.min' => 'El nombre debe tener al menos :min caracteres.',
            'nombre.max' => 'El nombre no puede exceder los :max caracteres.',

            'trabajo_estimado.integer' => 'El trabajo estimado debe ser un número entero.',
            'trabajo_estimado.min' => 'El trabajo estimado no puede ser negativo.',

            'prioridad.required' => 'Debe seleccionar una prioridad.',
            'prioridad.in' => 'La prioridad debe ser Alta, Media o Baja.',


        ]);
        $historia = new Historia();
        $historia->nombre = $request->nombre;
        $historia->trabajo_estimado = $request->trabajo_estimado;
        $historia->prioridad = $request->prioridad;
        $historia->descripcion =$request->descripcion;
        $historia->save();

        return redirect()->route('historias.index')->with('success', 'Historia Creada con Exito');
    }

    /**
     * Display the specified resource.
     */
    public function show(Historia $historia)
    {
        return view('historias.show',compact('historia'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Historia $historia)
    {
        return view('historias.edit',compact('historia'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Historia $historia)
    {
          $request -> validate([
            'nombre'=> 'required|string|min:3|max:255',
            'trabajo_estimado' => 'nullable|integer|min:0',
            'prioridad' => 'required|in:Alta,Media,Baja',
            'descripcion' => 'nullable|string|max:1000',
        ],
[   'nombre.required' => 'El nombre es obligatorio.',
            'nombre.min' => 'El nombre debe tener al menos :min caracteres.',
            'nombre.max' => 'El nombre no puede exceder los :max caracteres.',

            'trabajo_estimado.integer' => 'El trabajo estimado debe ser un número entero.',
            'trabajo_estimado.min' => 'El trabajo estimado no puede ser negativo.',

            'prioridad.required' => 'Debe seleccionar una prioridad.',
            'prioridad.in' => 'La prioridad debe ser Alta, Media o Baja.',


        ]);
        $historia->update();
        $historia->nombre = $request->nombre;
        $historia->trabajo_estimado = $request->trabajo_estimado;
        $historia->prioridad = $request->prioridad;
        $historia->descripcion =$request->descripcion;
        $historia->save();

        return redirect()->route('historias.index')->with('success', 'Historia Editada con Exito'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Historia $historia)
    {
        $historia->delete();
        return redirect()->route('historias.index')->with('success', 'Historia Borrada con Exito');
    }
}

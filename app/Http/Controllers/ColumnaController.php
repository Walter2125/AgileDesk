<?php

namespace App\Http\Controllers;

use App\Models\Columna;
use App\Models\Tablero;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;


class ColumnaController extends Controller
{
    // Crear nueva columna
    public function store(Request $request, $tableroId)
    {
        $tablero = Tablero::with('columnas')->findOrFail($tableroId);

        if ($tablero->columnas->count() >= 9) {
            return redirect()->back()
                ->withErrors(['nombre' => 'No se pueden crear más de 9 columnas en un tablero.'], 'crearColumna')
                ->withInput();
        }

        $validator = Validator::make($request->all(), [
            'nombre' => [
                'required',
                'string',
                'max:30',
                'regex:/^[^\d]+$/',
                'not_regex:/^\s*$/',
                Rule::unique('columnas')->where(function ($query) use ($tablero) {
                    return $query->where('tablero_id', $tablero->id);
                }),
            ],
            'posicion' => 'nullable|integer|min:1|max:9',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede tener más de 30 caracteres.',
            'nombre.unique' => 'Ya existe una columna con ese nombre en este tablero.',
            'nombre.regex' => 'El nombre no debe contener números.',
            'nombre.not_regex' => 'El nombre no puede estar vacío o contener solo espacios.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator, 'crearColumna')
                ->withInput();
        }

        Columna::create([
            'nombre' => $request->nombre,
            'posicion' => $request->posicion ?? $tablero->columnas->count() + 1,
            'tablero_id' => $tablero->id,
        ]);

        return redirect()->route('tableros.show', [
            'project' => $tablero->proyecto_id,
            'tablero' => $tablero->id,
        ])->with('success', 'Columna creada exitosamente.');
    }



    // Mostrar formulario de edición
    public function edit(Columna $columna)
    {
        return view('columnas.edit', compact('columna'));
    }

    // Actualizar nombre de la columna
    public function update(Request $request, $id)
    {
        $columna = Columna::findOrFail($id);

        $request->validate([
            'nombre' => [
                'required',
                'max:50',
                'regex:/^[^\d]*$/', // Evita números
                Rule::unique('columnas')->ignore($columna->id)->where(function ($query) use ($columna) {
                    return $query->where('tablero_id', $columna->tablero_id);
                }),
            ],
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.unique' => 'Ya existe una columna con ese nombre en este tablero.',
            'nombre.regex' => 'El nombre no debe contener números.',
        ]);

        $columna->nombre = $request->nombre;
        $columna->save();

        return redirect()->back()->with('success', 'Nombre de columna actualizado.');
    }


    // Eliminar columna
    public function destroy(Request $request, Columna $columna)
    {
        $modo = $request->input('modo');

        // Obtener el tablero y proyecto antes de eliminar la columna
        $tablero = $columna->tablero;
        $proyectoId = $tablero->proyecto_id;

        if ($modo === 'eliminar_todo') {
            // Eliminar historias asociadas primero
            $columna->historias()->delete();
        } elseif ($modo === 'solo_columna') {
            // Desasociar historias
            $columna->historias()->update(['columna_id' => null]);
        }

        $columna->delete();

        // Redirigir explícitamente a la vista del tablero
        return redirect()->route('tableros.show', [
            'project' => $proyectoId,
            'tablero' => $tablero->id,
        ])->with('success', 'Columna eliminada correctamente');
    }
}


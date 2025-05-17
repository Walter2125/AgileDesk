<?php

namespace App\Http\Controllers;

use App\Models\Columna;
use App\Models\Tablero;
use Illuminate\Http\Request;

class ColumnaController extends Controller
{
    // Crear nueva columna
    public function store(Request $request, $tableroId)
    {
        $tablero = Tablero::with('columnas')->findOrFail($tableroId);

        // Validar que no haya más de 9 columnas
        if ($tablero->columnas->count() >= 9) {
            return redirect()->back()->withErrors('No se pueden crear más de 9 columnas en un tablero.');
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'posicion' => 'nullable|integer|min:1|max:9',
        ]);

        Columna::create([
            'nombre' => $request->nombre,
            'posicion' => $request->posicion ?? $tablero->columnas->count() + 1,
            'tablero_id' => $tablero->id,
        ]);

        return redirect()->route('tableros.show', $tablero->proyecto_id)->with('success', 'Columna creada exitosamente.');
    }

    // Mostrar formulario de edición
    public function edit(Columna $columna)
    {
        return view('columnas.edit', compact('columna'));
    }

    // Actualizar nombre de la columna
    public function update(Request $request, Columna $columna)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $columna->update([
            'nombre' => $request->nombre,
        ]);

        // Para peticiones AJAX retornamos JSON
        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'nombre' => $columna->nombre]);
        }

        // Para peticiones normales, redireccionar
        return redirect()->route('tableros.show', $columna->tablero->proyecto_id)->with('success', 'Columna actualizada.');
    }


    // Eliminar columna
    public function destroy(Columna $columna)
    {
        $tablero = $columna->tablero;

        // Aquí podrías preguntar a qué columna mover sus historias antes de borrar

        // Si quieres mover historias antes, aquí iría la lógica

        $columna->delete();

        return redirect()->route('tableros.show', $tablero->proyecto_id)->with('success', 'Columna eliminada.');
    }
}

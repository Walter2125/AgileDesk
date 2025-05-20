<?php

namespace App\Http\Controllers;

use App\Models\HistorialCambio;
use Illuminate\Http\Request;

class HistorialCambioController extends Controller
{
    /**
     * Muestra una lista del historial de cambios.
     */
    public function index(Request $request)
    {
        // Opcional: filtrar por usuario, acción o sprint
        $query = HistorialCambio::query();

        if ($request->filled('usuario')) {
            $query->where('usuario', 'like', '%' . $request->usuario . '%');
        }

        if ($request->filled('accion')) {
            $query->where('accion', $request->accion);
        }

        if ($request->filled('sprint')) {
            $query->where('sprint', $request->sprint);
        }

        // Ordena por fecha descendente y pagina
        $historial = $query->orderBy('fecha', 'desc')->paginate(10);

        return view('historial.index', compact('historial'));
    }
}

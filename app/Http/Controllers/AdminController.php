<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sprint;
use App\Models\HistorialCambio;
use App\Models\Project;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
{
    $usuarios = User::paginate(5);
    $proyectos = Project::with('creator', 'users')->paginate(5);
    $historial = HistorialCambio::paginate(5);
    $sprints = Sprint::with('proyectos')->paginate(5);

    return view('users.admin.homeadmin', compact('usuarios', 'proyectos', 'historial', 'sprints'));
}
}

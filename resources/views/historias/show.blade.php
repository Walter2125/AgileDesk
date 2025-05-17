@extends('layouts.app')

@section('title')

@section('content')


<link rel="stylesheet" href="{{ asset('css/historias.css') }}">

<div class="container-fluid mi-container ">

       

    <div class="historia-container-fluid">
          <h1 class="titulo-historia">Detalle de la Historia</h1>
   
    <div class="historia-header">
        <h2 class="historia-title">{{ $historia->nombre }}</h2>
        <div class="historia-meta">
            <span class="badge bg-primary">{{ $historia->prioridad }}</span>
            <span class="badge bg-secondary">{{ $historia->trabajo_estimado }} horas</span>
        </div>
    </div>

  
    <div class="historia-content">
    
        <div class="historia-section">
            <h3 class="section-title">Descripción</h3>
            <div class="section-content">
                {{ $historia->descripcion }}
            </div>
        </div>

    
        <div class="historia-details">
            <div class="detail-item">
                <span class="detail-label">Estado:</span>
                <span class="detail-value">{{ $historia->estado ?? 'No especificado' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Sprint:</span>
                <span class="detail-value">{{ $historia->sprint ?? 'No asignado' }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Fecha creación:</span>
                <span class="detail-value">{{ $historia->created_at->format('d/m/Y') }}</span>
            </div>
        </div>
    </div>
</div>

<a href="{{ route('tareas.show', $historia->id) }}" 
   class="btn text-primary border border-primary rounded-pill px-4 py-2 shadow-sm"
   style="background-color: #e6f2ff;">
   📋 Agregar Tareas
</a>
   
        <div class="mb-3 d-flex justify-content-end">
            <a href="{{ route('historias.index') }}" class="btn btn-secondary">← Regresar al listado</a>
            <a href="{{ route('historias.edit', $historia->id) }}" class="btn btn-primary ms-2">Editar Historia</a>
        </div>
</div>

@endsection
@extends('layouts.app')

@section('title')

@section('content')


<link rel="stylesheet" href="{{ asset('css/historias.css') }}">

<div class="container-fluid mi-container ">

       

    <div class="historia-container-fluid">
          <h1 class="titulo-historia">Detalle de la Historia</h1>
   
    <div class="historia-header">
        <h2 class="historia-title" 
            style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 300px; display: block;" 
            title="{{ $historia->nombre }}">
            {{ $historia->nombre }}
        </h2>

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
            <div class="detail-item">
                <span class="detail-label">Asignado a:</span>
                <span class="detail-value">
                    {{ $historia->usuario ? $historia->usuario->name : 'No asignado' }}
                </span>
            </div>
        </div>
    </div>
</div>

   
        <div class="mb-3 d-flex justify-content-end">
                    <a href="{{ route('tableros.show', $historia->proyecto_id) }}" class="btn btn-secondary">Atras</a>

                    <a href="{{ route('historias.edit', $historia->id) }}" class="btn btn-primary ms-2">Editar</a>
                
                <form action="{{ route('historias.destroy', $historia->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                        <button type="button" class="btn btn-danger ms-2" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $historia->id }}"> Borrar</button>
                        </form>
                            <!-- Modal -->
                    <div class="modal fade" id="confirmDeleteModal{{ $historia->id }}" tabindex="-1" aria-labelledby="confirmDeleteLabel{{ $historia->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmDeleteLabel{{ $historia->id }}">¿Desea eliminar esta historia?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            Se eliminara la historia "<strong style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: inline-block; max-width: 300px;" title="{{ $historia->nombre }}">
                                                        {{ $historia->nombre }}
                                                        </strong>"
                            Esta acción no se puede deshacer.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            
                            <form action="{{ route('historias.destroy', $historia->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Confirmar</button>
                            </form>
                        </div>
                        </div>
                    </div>
                    </div>
        </div>
</div>

@endsection
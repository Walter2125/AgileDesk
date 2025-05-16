@extends('layouts.app')

@section('title','Lista de Historias')

<!--<i class="bi bi-plus"></i>
<i class="bi bi-trash"></i>
<i class="bi bi-pencil-square"></i> -->
@section('content')

   

<div class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success mt-2">
                {{ session('success') }}
            </div>
        
    @endif
    <h1>Lista de Historias</h1>

    <a href="{{ route('historias.create') }}" class="btn btn-primary">Crear</a>
        <table class="table">
            <thead>
            <tr>
            <th scope="col">ID</th>
            <th scope="col">Nombre</th>
            <th scope="col">Descripcion</th>
            </tr>
            </thead>

    @foreach ($historias as $historia )

            <tbody>
            <tr>
            <th scope="row">{{$historia -> id  }}</th>
            <td>{{ $historia -> nombre }}</td>
            <td>{{  $historia -> descripcion }}</td>
            <td>
              <a href="{{ route('historias.show', $historia->id) }}" class="btn btn-primary">VER</a>
                 <a href="{{ route('historias.edit', $historia->id) }}" class="btn btn-primary">EDITAR</a>
                 <form action="{{ route('historias.destroy', $historia->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                   <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $historia->id }}"> DELETE</button>
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
                    Se eliminara la historia "<strong>{{ $historia->nombre }}</strong>"
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
            </td>
            </tr>
             </tbody>
        
    @endforeach
        </table>


              

</div>

@endsection


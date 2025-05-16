
@extends('layouts.app')

@section('content')
    <div class="bg-gray-100 p-10" style="background-color: rgba(243, 244, 246, 0.5);" x-data="kanbanBoard({{ $tablero->id }})">

        <div class="w-full mx-auto bg-white p-6 rounded-lg shadow-lg overflow-x-auto h-screen">

            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-center mb-6 flex-grow">{{ $project->name }}</h2>
                <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 ml-4">
                    Crear Sprint
                </button>
            </div>

            <button @click="showAddModal = true" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 mb-4">
                + Agregar columna
            </button>

            <div class="overflow-x-auto">
                <div class="flex gap-4 min-w-full">
                    @foreach($tablero->columnas->sortBy('posicion') as $columna)
                        <div class="{{ $tablero->columnas->count() <= 4 ? 'flex-1' : 'w-60' }} bg-white border rounded-2xl shadow flex flex-col max-h-[80vh] {{ $columna->es_backlog ? 'border-blue-500 ring-2 ring-blue-300' : '' }}">

                            <div class="flex justify-between items-center p-2 border-b">
                                @if ($columna->es_backlog)
                                    <span class="titulo-columna text-lg font-bold text-blue-700">Backlog</span>
                                @else
                                    <span class="titulo-columna text-lg font-bold cursor-pointer" @click="editColumn({{ $columna->id }}, '{{ $columna->nombre }}')">
                                    {{ $columna->nombre }}
                                </span>
                                @endif
                                <button class="text-red-500 cursor-not-allowed" title="Eliminar columna" disabled>🗑️</button>
                            </div>

                            <div class="min-h-[150px] space-y-2 overflow-y-auto flex-1 p-2">
                                @if ($columna->historias->count())
                                    @foreach ($columna->historias as $historia)
                                        <div class="card bg-white p-3 rounded shadow cursor-pointer">
                                            <div class="font-semibold text-gray-800">Nombre:
                                                <span>{{ $historia->nombre ?? $historia->titulo }}</span>
                                            </div>
                                            <div class="font-semibold text-gray-800">Prioridad:
                                                <span>{{ $historia->prioridad ?? 'N/A' }}</span>
                                            </div>
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th scope="col">
                                                        <a href="{{ route('formulario.edit', $historia->id) }}" class="btn btn-primary boton-uniforme">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                    </th>
                                                    <th scope="col">
                                                        <form action="{{ route('formulario.destroy', $historia->id) }}" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger boton-uniforme">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-center text-gray-400 mt-10 text-sm">No hay historias en esta columna</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        {{-- MODAL agregar columna --}}
        <div x-show="showAddModal" x-cloak class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center">
            <div class="bg-white rounded p-6 w-80">
                <h2 class="text-xl font-bold mb-4">Nueva Columna</h2>
                <input type="text" x-model="newColumnName" placeholder="Nombre"
                       class="w-full border rounded px-3 py-2 mb-4" />
                <div class="flex justify-end gap-2">
                    <button @click="showAddModal = false" class="px-4 py-2 border rounded hover:bg-gray-100">Cancelar</button>
                    <button @click="addColumn" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Guardar</button>
                </div>
            </div>
        </div>

        {{-- MODAL editar columna --}}
        <div x-show="showEditModal" x-cloak class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center">
            <div class="bg-white rounded p-6 w-80">
                <h2 class="text-xl font-bold mb-4">Editar Columna</h2>
                <input type="text" x-model="editingName" placeholder="Nuevo nombre"
                       class="w-full border rounded px-3 py-2 mb-4" />
                <div class="flex justify-end gap-2">
                    <button @click="showEditModal = false" class="px-4 py-2 border rounded hover:bg-gray-100">Cancelar</button>
                    <button @click="updateColumn" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Actualizar</button>
                </div>
            </div>
        </div>

    </div>
@stop

@section('adminlte_js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="{{ asset('color.js') }}"></script>

    <script>
        function kanbanBoard(tableroId) {
            return {
                showAddModal: false,
                showEditModal: false,
                newColumnName: '',
                editingId: null,
                editingName: '',

                async addColumn() {
                    if (!this.newColumnName.trim()) return;
                    try {
                        const res = await fetch(`/columnas/${tableroId}/store`, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            body: JSON.stringify({ nombre: this.newColumnName })
                        });
                        if (res.ok) {
                            location.reload();
                        } else {
                            alert('No se pudo crear la columna. Verifica el límite.');
                        }
                    } catch (error) {
                        console.error(error);
                        alert('Error al crear columna.');
                    }
                },

                editColumn(id, nombre) {
                    this.editingId = id;
                    this.editingName = nombre;
                    this.showEditModal = true;
                },

                async updateColumn() {
                    try {
                        const res = await fetch(`/columnas/${this.editingId}/update`, {
                            method: 'PUT',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            body: JSON.stringify({ nombre: this.editingName })
                        });
                        if (res.ok) {
                            location.reload();
                        } else {
                            alert('Error al actualizar columna.');
                        }
                    } catch (err) {
                        console.error(err);
                        alert('Error al actualizar.');
                    }
                }
            }
        }
    </script>
@stop

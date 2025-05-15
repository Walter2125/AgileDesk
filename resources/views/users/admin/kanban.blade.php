@extends('layouts.app')

@section('content')
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center space-x-4">
                <h1 class="text-3xl font-bold">{{ $tablero->proyecto->nombre }}</h1>

                <form method="GET">
                    <label class="font-semibold mr-2">Sprint:</label>
                    <select name="sprint_id" onchange="this.form.submit()" class="border rounded p-2">
                        <option value="">-- Todos los Sprints --</option>
                        @foreach($sprints as $sprint)
                            <option value="{{ $sprint->id }}" {{ request('sprint_id') == $sprint->id ? 'selected' : '' }}>
                                {{ $sprint->nombre }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            @if(auth()->user()->rol === 'admin')
                <div class="space-x-2">
                    <a href="{{ route('sprints.create', $tablero->id) }}"
                       class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                        Crear Sprint
                    </a>
                    @if($tablero->columnas->count() < 9)
                        <button id="agregarColumnaBtn"
                                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                            Agregar Columna
                        </button>
                    @endif
                </div>
            @endif
        </div>

        <div id="kanban" class="flex space-x-4 overflow-x-auto pb-4">
            @foreach($tablero->columnas as $columna)
                <div class="flex-shrink-0 bg-white shadow rounded-lg p-4 columna"
                     style="width: {{ $tablero->columnas->count() <= 4 ? '100%' : '300px' }}; max-height: 75vh; overflow-y: auto;">
                    <div class="mb-4">
                        <h2 class="text-lg font-semibold text-gray-800">{{ $columna->nombre }}</h2>
                    </div>

                    <div class="historias space-y-3" data-columna-id="{{ $columna->id }}">
                        @if($columna->historias->count())
                            @foreach($columna->historias as $historia)
                                <div class="bg-gray-100 p-3 rounded shadow draggable" data-id="{{ $historia->id }}">
                                    <h3 class="font-medium text-gray-900">{{ $historia->titulo }}</h3>
                                    <p class="text-sm text-gray-600">{{ $historia->descripcion }}</p>
                                </div>
                            @endforeach
                        @else
                            <div class="text-gray-500 italic">No hay historias en esta columna</div>
                        @endif
                    </div>

                    @if(auth()->user()->rol === 'admin')
                        <form class="crear-historia mt-4" data-columna-id="{{ $columna->id }}">
                            @csrf
                            <input type="text" name="titulo" placeholder="Título..."
                                   class="w-full p-2 mb-2 border rounded">
                            <textarea name="descripcion" placeholder="Descripción..."
                                      class="w-full p-2 mb-2 border rounded"></textarea>
                            <input type="hidden" name="columna_id" value="{{ $columna->id }}">
                            <button type="submit"
                                    class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700">
                                Crear Historia
                            </button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    {{-- Modal para crear columna --}}
    @if(auth()->user()->rol === 'admin')
        <div id="modalColumna" class="fixed inset-0 bg-black/50 z-40 hidden items-center justify-center">
            <div class="bg-white p-6 rounded-lg shadow-lg w-96 relative z-50">
                <h2 class="text-xl font-semibold mb-4">Agregar Columna</h2>
                <form id="formCrearColumna">
                    @csrf
                    <input type="hidden" name="tablero_id" value="{{ $tablero->id }}">
                    <input type="text" name="nombre" placeholder="Nombre de la columna"
                           class="w-full p-2 mb-4 border rounded" required>
                    <div class="flex justify-end space-x-2">
                        <button type="button" id="cancelarModalColumna"
                                class="px-4 py-2 bg-gray-400 text-white rounded">Cancelar</button>
                        <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                            Crear
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        @if(auth()->user()->rol === 'admin')
        document.getElementById('agregarColumnaBtn')?.addEventListener('click', () => {
            document.getElementById('modalColumna').classList.remove('hidden');
            document.getElementById('modalColumna').classList.add('flex');
        });
        document.getElementById('cancelarModalColumna')?.addEventListener('click', () => {
            document.getElementById('modalColumna').classList.add('hidden');
        });

        document.getElementById('formCrearColumna')?.addEventListener('submit', async function(e) {
            e.preventDefault();
            const form = e.target;
            const data = new FormData(form);

            const res = await fetch("{{ route('columnas.store') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: data
            });

            if (res.ok) {
                location.reload();
            }
        });
        @endif

        document.querySelectorAll('.crear-historia').forEach(form => {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                const data = new FormData(form);

                const res = await fetch("{{ route('historias.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: data
                });

                if (res.ok) {
                    location.reload();
                }
            });
        });

        @if(auth()->user()->rol === 'admin')
        document.querySelectorAll('.historias').forEach(columna => {
            new Sortable(columna, {
                group: 'historias',
                animation: 150,
                onEnd: async (evt) => {
                    const historiaId = evt.item.dataset.id;
                    const nuevaColumnaId = evt.to.dataset.columnaId;

                    await fetch(`{{ url('/historias/mover') }}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ historia_id: historiaId, columna_id: nuevaColumnaId })
                    });
                }
            });
        });
        @endif
    </script>
@endsection

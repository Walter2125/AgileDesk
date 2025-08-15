@extends('layouts.app')

@section('mensaje-superior')
    Backlog
@endsection

@section('content')
    <div class="container-fluid mt-4 px-4">


        <div class="mb-3 d-flex flex-column flex-md-row justify-content-end gap-2 mx-n3 mx-md-n4">
            <div class="input-group w-100">
    <span class="input-group-text" style="height: 40px">
        <i class="bi bi-search"></i>
    </span>
                <input type="text" id="buscadorHistorias" class="form-control" placeholder="Buscar historia por nombre..." style="height: 40px">
                <button class="btn btn-outline-secondary limpiar-busqueda" type="button" id="limpiarBusqueda" style="height: 40px">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            @if($proyecto->sprints->count() > 0)
                <form method="GET" class="d-flex">
                    <select name="sprint_id" class="form-select"
                            style="max-height: 40px; height: 40px; width: 250px;border-radius: 0.375rem"
                            onchange="this.form.submit()">
                        <option value="">Todas las Historias</option>
                        @foreach ($proyecto->sprints as $sprint)
                            <option value="{{ $sprint->id }}" {{ $sprintId == $sprint->id ? 'selected' : '' }}>
                                {{ $sprint->nombre }}
                            </option>
                        @endforeach
                    </select>
                </form>
            @endif


            <a href="{{ route('historias.create', ['proyecto' => $proyecto->id]) }}"
               class="btn btn-primary d-flex align-items-center"
               style="height: 40px;">
                Agregar Historia
            </a>


            @if(auth()->user()->usertype === 'admin' || auth()->user()->usertype === 'superadmin')
                <a href="{{ route('backlog.export-pdf', ['project' => $proyecto->id, 'sprint_id' => $sprintId]) }}"
                   class="btn btn-secondary d-flex align-items-center"
                   style="height: 40px;"
                   title="Exportar a PDF">
                    <i class="bi bi-file-earmark-pdf me-1"></i> Exportar a PDF
                </a>
            @endif
        </div>


        <div class="mt-4 mx-n3 mx-md-n4">
            @forelse ($historias as $historia)
                <a href="{{ route('historias.show', $historia->id) }}" class="text-decoration-none text-dark">
                    <div class="card mb-2 p-3" style="transition: box-shadow 0.2s; cursor: pointer; width: 100%;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong> {{ $historia->proyecto->codigo ?? 'SIN-CÓDIGO' }}-{{ $historia->numero }} : {{ $historia->nombre }}</strong><br>
                                <small class="text-muted">Prioridad: {{ $historia->prioridad }}</small><br>
                                <small class="text-muted">
                                    Estado:
                                    @if ($historia->columna)
                                        {{ $historia->columna->nombre }}
                                    @else
                                        <span class="text-danger">No asignado</span>
                                    @endif
                                </small>
                            </div>
                            @if (is_null($historia->columna_id))
                                <i class="bi bi-exclamation-circle-fill text-danger fs-4" title="No asignada a ninguna columna"></i>
                            @endif
                        </div>
                    </div>
                </a>
            @empty
                <div class="alert alert-info">No hay historias en el backlog para este proyecto.</div>
            @endforelse
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const buscador = document.getElementById("buscadorHistorias");
            const limpiarBtn = document.getElementById("limpiarBusqueda");


            function normalizar(texto) {
                return texto
                    .toLowerCase()
                    .normalize("NFD")
                    .replace(/[\u0300-\u036f]/g, "");
            }


            function realizarBusqueda() {
                const textoBusqueda = normalizar(buscador.value.trim());

                const historias = document.querySelectorAll(".card.mb-2.p-3");

                historias.forEach(historia => {
                    const textoHistoria = normalizar(historia.textContent);
                    if (textoHistoria.includes(textoBusqueda)) {
                        historia.style.display = "block";
                    } else {
                        historia.style.display = "none";
                    }
                });
            }


            buscador.addEventListener("input", realizarBusqueda);


            limpiarBtn.addEventListener("click", function () {
                buscador.value = "";
                const historias = document.querySelectorAll(".card.mb-2.p-3");
                historias.forEach(h => h.style.display = "block");
            });
        });
    </script>




    <style>
        @media (max-width: 576px) {
            .form-select,
            .btn {
                width: 100% !important;
            }

            form.d-flex {
                width: 100%;
            }
        }
    </style>

@endsection

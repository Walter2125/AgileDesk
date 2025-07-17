@props(['breadcrumbs' => []])

@if(is_array($breadcrumbs) && count($breadcrumbs))
<nav aria-label="breadcrumb" class="mb-2 mt-2" style="display: block !important; visibility: visible !important;">
  <ol class="breadcrumb bg-light shadow-sm" style="display: flex !important; visibility: visible !important; margin: 0 !important; padding: 10px var(--navbar-padding-x, 1rem) !important; border-radius: 0.5rem !important;">
    @foreach ($breadcrumbs as $item)
      @if (!$loop->last)
        <li class="breadcrumb-item" style="display: inline-flex !important;">
          <a href="{{ $item['url'] ?? '#' }}" class="text-decoration-none text-primary">
            @if($loop->first)
              <i class="bi bi-house-door me-1"></i>
            @endif
            {{ $item['label'] }}
          </a>
        </li>
      @else
        <li class="breadcrumb-item active fw-semibold" aria-current="page" style="display: inline-flex !important;">
          {{ $item['label'] }}
        </li>
      @endif
    @endforeach
  </ol>
</nav>
@endif

<style>
/* Mejorar los breadcrumbs para móviles */
@media (max-width: 991.98px) {
  .breadcrumb-item {
    font-size: 0.875rem;
  }
  
  .breadcrumb-item:not(:last-child):not(:first-child) {
    display: none; /* Ocultar elementos intermedios en móvil */
  }
  
  .breadcrumb-item:nth-last-child(2) {
    display: flex !important; /* Mostrar penúltimo elemento */
  }
}

.breadcrumb-item + .breadcrumb-item::before {
  content: "›";
  color: #6c757d;
  font-weight: bold;
}

/* Estilos generales para los breadcrumbs */
.breadcrumb {
  border-radius: 0.5rem !important;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
  padding: 10px var(--navbar-padding-x, 1rem) !important;
  transition: all 0.3s ease;
  border: 1px solid #e9ecef !important;
}

/* Estilos específicos para el modo oscuro */
.dark-mode .breadcrumb {
  background-color: #2a2a36 !important; /* Gris oscuro personalizado */
  border-color: var(--dark-border-primary) !important;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3) !important;
}

.dark-mode .breadcrumb-item + .breadcrumb-item::before {
  color: var(--dark-text-terciary) !important;
}

.dark-mode .breadcrumb-item {
  color: var(--dark-text-secondary) !important;
}

.dark-mode .breadcrumb-item.active {
  color: var(--dark-text-primary) !important;
}

.dark-mode .breadcrumb-item a {
  color: var(--dark-accent-primary) !important;
}

.dark-mode .breadcrumb-item a:hover {
  color: var(--dark-accent-hover) !important;
}
</style>
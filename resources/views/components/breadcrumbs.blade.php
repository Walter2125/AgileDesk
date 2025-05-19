@props(['breadcrumbs' => []])

@if(is_array($breadcrumbs) && count($breadcrumbs))
<nav aria-label="breadcrumb" class="mb-3 mt-2">
  <ol class="breadcrumb bg-white rounded shadow-sm px-3 py-2">
    @foreach ($breadcrumbs as $item)
      @if (!$loop->last)
        <li class="breadcrumb-item">
          <a href="{{ $item['url'] ?? '#' }}" class="text-decoration-none">
            {{ $item['label'] }}
          </a>
        </li>
      @else
        <li class="breadcrumb-item active" aria-current="page">
          {{ $item['label'] }}
        </li>
      @endif
    @endforeach
  </ol>
</nav>
@endif
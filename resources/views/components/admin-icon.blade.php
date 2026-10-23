@props(['name', 'class' => 'h-4 w-4'])

@php
    $paths = [
        'add' => ['M12 5v14m-7-7h14'],
        'archive' => ['M3 4h18v4H3z', 'M5 8v12h14V8', 'M10 12h4'],
        'back' => ['M19 12H5', 'm12 19-7-7 7-7'],
        'check' => ['m5 12 4 4L19 6'],
        'delete' => ['M3 6h18', 'M8 6V4h8v2', 'm19 6-1 14H6L5 6', 'M10 11v5', 'M14 11v5'],
        'edit' => ['m16 4 4 4', 'M4 20l4.5-1 11-11a2.1 2.1 0 0 0-3-3l-11 11L4 20z'],
        'external' => ['M14 3h7v7', 'M10 14 21 3', 'M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6'],
        'image' => ['M4 5h16v14H4z', 'm4 15 4-4 4 4 3-3 5 5', 'M9 9h.01'],
        'inbox' => ['M4 4h16v16H4z', 'M4 13h4l2 3h4l2-3h4'],
        'reply' => ['m9 17-5-5 5-5', 'M4 12h10a6 6 0 0 1 6 6v2'],
        'save' => ['M5 3h12l4 4v14H3V3h2z', 'M7 3v6h10V3', 'M7 21v-8h10v8'],
        'sort' => ['M8 7h12', 'M8 12h8', 'M8 17h4', 'm4 7 2-2 2 2', 'M6 5v14'],
        'view' => ['M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z', 'M12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6z'],
        'close' => ['m18 6-12 12', 'm6 6 12 12'],
    ];
@endphp

<svg {{ $attributes->class($class) }} fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
    @foreach($paths[$name] ?? [] as $path)
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $path }}"/>
    @endforeach
</svg>

@foreach($data as $element)
    @php
        $try_blade = str_replace("_", ".",$element['type']);
    @endphp

    @if (view()->exists($try_blade))
        {{-- The Blade view 'your.blade.view' exists --}}
        @include($try_blade, ['data' => $element])
    @else
        {{-- Handle the case where the view does not exist --}}
        {{-- For example, display an alternative content --}}
        <p>The blade {!! $try_blade !!} does not exists.</p>
    @endif
@endforeach

@php
if(isset($debug))
    dd($data);
@endphp

@if(!empty($data['attributes']))

@endif

@switch($data['type'])
    @case('uxmal_uxmal')
        @if(!empty($data['elements']))
            @foreach($data['elements'] as $element)
                @isset($element['type'])
                    @php
                        $try_blade = str_replace('_', '.', $element['type']);
                    @endphp
                    @if (view()->exists($try_blade))
                        {{-- The Blade view 'your.blade.view' exists --}}
                        @include($try_blade, ['data' => $element])
                    @else
                        {{-- Handle the case where the view does not exist --}}
                        {{-- For example, display an alternative content --}}
                        <p>The blade {!! $try_blade !!} does not exists.</p>
                    @endif
                @endisset
            @endforeach
        @endif
    @break;
    @default
        @php
            $try_blade = str_replace('_', '.', $data['type']);
        @endphp
        @if (view()->exists($try_blade))
            {{-- The Blade view 'your.blade.view' exists --}}
            @include($try_blade, ['data' => $data])
        @else
            {{-- Handle the case where the view does not exist --}}
            {{-- For example, display an alternative content --}}
            <p>The blade {!! $try_blade !!} does not exists.</p>
        @endif
    @break;
@endswitch
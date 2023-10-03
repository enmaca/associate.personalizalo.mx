@php

        @endphp
@foreach($data as $element => $_data)
    @switch($element)
        @case('row')
            @include('uxmal.row', [ 'data' => $_data])
            @break
        @case('elements')
            @include('uxmal.elements', [ 'data' => $_data])
            @break
        @default
            @isset($_data['uxmal'])
                @include('uxmal.form.'.$_data['uxmal'], [ 'data' => $_data['data'] ])
            @else
                @isset($_data['livewire'])
                    @livewire($_data['livewire'])
                @else
                    @include('uxmal.'.$element, [ 'data' => []])
                @endisset
            @endisset
            @break
    @endswitch
@endforeach

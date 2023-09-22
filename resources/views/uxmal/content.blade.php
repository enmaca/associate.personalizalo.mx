@foreach($content as $component => $data)
    @switch($component)
        @case('card')
            @include('uxmal.card', ['data' => $data]);
            @break
        @case('listjs')
            @include('uxmal.listjs', ['data' => $data]);
            @break
        @case('livewire')
            @php
            echo "@livewire('$data ');";
            @endphp
            @break
    @endswitch
@endforeach
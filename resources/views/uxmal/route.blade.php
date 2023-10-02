@php

@endphp
@foreach($data as $element => $_data)
    @include('uxmal.'.$element, [ 'data' => $_data ])
@endforeach
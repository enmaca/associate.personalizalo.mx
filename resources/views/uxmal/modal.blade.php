@php

if( !isset($data['uxmal']))
    $data['uxmal'] = 'bootstrap';

@endphp
@include('uxmal.modal.'.$data['uxmal'])
@php

@endphp
<div {!! $data['attributes'] !!}>
    @isset($data['elements'])
        @include('uxmal.elements', [ 'data' => $data['elements'] ])
    @endisset
</div>
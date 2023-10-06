@php
//dd($data['attributes']);
@endphp
<form {!! $data['attributes'] !!}>
    @csrf
    @include('uxmal.elements', [ 'data' => $data['elements']])
</form>
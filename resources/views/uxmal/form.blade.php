@php
    /*
     * Defaults
     */
/*
 * 'form' => [
            'id' => 'NewOrderFrom',
            'class' => '',
            'action' => route('test'),
            'method' => 'POST'
 */

if(!isset($data['id']))
    $data['id'] = '_'.bin2hex(random_bytes(3));

if(empty($data['class']))
    $data['class'] = [];

if(empty($data['method']))
    $data['method'] = 'POST';

@endphp
<form id="{!! $data['id'] !!}" class="{!! join(" ", $data['class']) !!}" method="{!! $data['method'] !!}">
    @csrf
    @include('uxmal.form.elements', [ 'data' => $data['elements']])
</form>
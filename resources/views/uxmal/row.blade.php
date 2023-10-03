@php

    /**
     * data.class = (array) Div Classes
     * data.attributes = (array) Attributes
     * data.elements = (array) Elements
     */
    if(empty($data['class']) || !is_array($data['class']))
        $data['class'] = [];

    if(empty($data['attributes']) || !is_array($data['attributes']))
        $data['attributes'] = [];

@endphp
<div class="{!! join(" ", $data['class']) !!}" {!! join(" ", $data['attributes']) !!}>
    @isset($data['elements'])
        @include('uxmal.elements', [
            'data' => $data['elements']
        ])
    @else
        @include('uxmal.elements', [
            'data' => $data
        ])
    @endisset
</div>
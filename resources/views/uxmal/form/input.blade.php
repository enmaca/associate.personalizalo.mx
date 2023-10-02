@php
    /**
     *
     *
     * row.class = (array) classes
     * label.class = (array) classes
     * field.type = (string) text |
     * field.id = (string) input id=, (defaults) {field.name}Id
     * field.name = (string) input name=,
     * field.label = (string) Label,
     * field.placeholder' => (string) Place Holder
     * field.value = (string) Value of the input field
     * field.require = (boolean)
     * field.readonly = (boolean)
     */

    if(!isset($data['row']['class']))
        $data['row']['class'] = [
            'mb-3'
            ];

    if(!isset($data['label']['class']))
        $data['label']['class'] = [
            'form-label'
            ];

    if(!isset($data['field']['id']))
        $data['field']['id'] = $data['field']['name'].'Id';

    if(!isset($data['field']['type']))
        $data['field']['type'] = 'text';

    if(!isset($data['field']['class']))
        $data['field']['class'] = [
            'form-control'
            ];

@endphp
<div class="{!! join(" ", $data['row']['class']) !!}">
    <label for="{!! $data['field']['id'] !!}" class="{!! join(" ", $data['label']['class']) !!}">{{ $data['field']['label'] }}</label>
    <input type = "{!! $data['field']['type'] !!}"
           name="{!! $data['field']['name'] !!}"
           @isset($data['field']['class']) class="{!! join(" ", $data['field']['class']) !!}" @endisset
           @isset($data['field']['placeholder']) placeholder="{!! $data['field']['placeholder'] !!}" @endisset
           @isset($data['field']['required']) required @endisset
           @isset($data['field']['readonly']) readonly @endisset/>
</div>
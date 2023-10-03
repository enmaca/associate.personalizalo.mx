<!--

$data = [
    'type' => 'button',
    'class' => ''
    'onclick' => ''
    'attributes' => ''
    'slot' => ''
]

-->
<button
        type="{!! $data['type'] !!}"
        class="{!! $data['class'] !!}"
        @isset($data['onclick'])
            onclick="{!! $data['onclick'] !!}"
        @endisset
        @isset($data['attributes'])
            {!! join(" ", $data['attributes']) !!}
        @endisset
        >{!! $data['slot'] !!}
</button>
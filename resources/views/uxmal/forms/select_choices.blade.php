<div data-uxmal-type="select-choices" data-uxmal-id="{!! $id !!}" class="input-group-md mb-3">
    <label for="{!! $name !!}" class="form-label text-muted">{!! $label !!}</label>
    <select @if(!empty($wire)) {!! implode(" ", $wire) !!} @endif class="form-control" id="{!! $id !!}" name="{!! $name !!}" data-choices {!! implode(" ", $data_choices_opts) !!}  >
        @if( !empty($place_holder_option) )
            <option value="{!! $place_holder_option['value'] !!}">{!! $place_holder_option['name'] !!}</option>
        @endif
        @foreach($options as $key => $value)
            <option value="{!! $key !!}">{!! $value !!}</option>
        @endforeach
    </select>
</div>
@pushonce('scss')
    @vite('resources/scss/uxmal/choices.scss')
@endpushonce
@pushonce('scripts')
    @vite('resources/js/uxmal/choices.js')
@endpushonce
@pushonce('onload-excute')
    if (window.init_choices) {
        window.init_choices();
    }
@endpushonce
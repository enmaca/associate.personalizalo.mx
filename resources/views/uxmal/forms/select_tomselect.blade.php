<div data-uxmal-type="select-tomselect" data-uxmal-id="{!! $id !!}" class="input-group-md mb-3">
    <label for="{!! $name !!}" class="form-label text-muted">{!! $label !!}</label>
    <select @if(!empty($wire)) {!! implode(" ", $wire) !!} @endif class="form-control" id="{!! $id !!}" name="{!! $name !!}" data-tomselect {!! implode(" ", $data_choices_opts) !!}  >
        @if( !empty($place_holder_option) )
            <option value="{!! $place_holder_option['value'] !!}">{!! $place_holder_option['name'] !!}</option>
        @endif
        @foreach($options as $key => $value)
            <option value="{!! $key !!}">{!! $value !!}</option>
        @endforeach
    </select>
</div>
@pushonce('scss')
    @vite('resources/scss/uxmal/tomselect.scss')
@endpushonce
@pushonce('scripts')
    @vite('resources/js/uxmal/tomselect.js')
@endpushonce
@pushonce('onload-excute')
if (window.init_tomselect) {
    window.init_tomselect();
}
@endpushonce
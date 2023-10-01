<div data-uxmal-type="select-tomselect" data-uxmal-id="{!! $id !!}" class="input-group-md mb-3 row d-flex align-items-end">
    <div class="@isset($button['id']) col-10 @else col-12 @endisset">
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
    @isset($button['id'])
        <div class="col-2">
            @isset($button['ri_icon'])
                <button {!! 'id="'.$button['id'].'"' !!} type="button" class="btn btn-outline-primary btn-icon"><i class="ri-{!! $button['ri_icon'] !!}"></i></button>
            @else
                @isset($button['text'])
                    <button {!! 'id="'.$button['id'].'"' !!} type="button" class="btn btn-primary">{!! $button['text'] !!}</button>
               @endisset
            @endisset
        </div>
    @endisset
</div>
@pushonce('scss')
    @vite('resources/scss/uxmal/tomselect.scss')
@endpushonce
@pushonce('scripts')
    @vite('resources/js/uxmal/tomselect.js')
@endpushonce
<!-- if (window.init_tomselect) { window.init_tomselect(); } } -->
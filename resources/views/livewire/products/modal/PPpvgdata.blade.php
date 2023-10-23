@php
$key = '___KEY___';
@endphp
<div class="col-12">
    <hr style="border-color: #bbb;background-color: #bbb;">
</div>
<label class="mb-1 d-block">TitlePVG:</label>
<div id="printVariant" class="print-variant">
    @foreach( $data['items'] as $pvg_item)
        <input id="variant_{{ $key }}_{{ $loop->iteration }}" type="radio" class="btn-check" name="variant_{{ $key }}" autocomplete="off" @if ($loop->iteration == 1) checked @endif>
        <label for="variant_{{ $key }}_{{ $loop->iteration }}" class="btn btn-outline-light w-100 d-flex align-items-center border rounded">
            <img data-pvgd-id="{!! $pvg_item['id'] !!}" src="{!! $pvg_item['preview_path'] !!}" alt="{!! $pvg_item['display_name'] !!}" width="70">
            <div class="ms-2 small d-flex flex-column justify-content-center align-items-start">
                <b>{!! $pvg_item['display_name'] !!}</b>
                <span class="text-muted">Aprox. tamaño x tamaño</span>
            </div>
        </label>
    @endforeach
</div>
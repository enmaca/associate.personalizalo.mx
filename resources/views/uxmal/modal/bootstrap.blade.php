@php

@endphp
<div {!!  $data['attributes']; !!} tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="exampleModalLabel">{{ $data['header-label'] }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
            </div>
            <div class="modal-body">
                @isset($data['body'])
                    @include('uxmal.route', ['data' => $data['body']] )
                @endisset
            </div>
            <div class="modal-footer">
                <div class="hstack gap-2 justify-content-end">
                    @isset($data['footer']['elements'])
                        @include('uxmal.elements', [ 'data' => $data['footer']['elements']])
                    @endisset
                </div>
            </div>
        </div>
    </div>
</div>
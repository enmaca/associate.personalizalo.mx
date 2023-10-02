@php

@endphp
<div class="modal fade" id="createOrderModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="exampleModalLabel">Crear Nuevo Pedido</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
            </div>
            <div class="modal-body">
                @isset($data['body'])
                    @include('uxmal.route', ['data' => $data['body']])
                @endisset
            </div>
            <div class="modal-footer">
                <div class="hstack gap-2 justify-content-end">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" id="add-btn">Crear Pedido</button>
                    <button type="button" class="btn btn-success" id="edit-btn">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>
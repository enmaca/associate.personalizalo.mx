

    <div class="modal fade" id="createOrderModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light p-3">
                    <h5 class="modal-title" id="exampleModalLabel">Crear Nuevo Pedido</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="close-modal"></button>
                </div>
                <form id="NewOrderFrom" class="tablelist-form" method="POST">
                    @csrf
                    <div class="modal-body">
                        @livewire('client.search.select')
                        <div class="mb-3">
                            <label for="customerMobile" class="form-label">Celular</label>
                            <input name="customerMobile" class="form-control" placeholder="Ingresa Número de Celular"
                                   required/>
                        </div>

                        <div class="mb-3">
                            <label for="customerName" class="form-label">Nombre</label>
                            <input name="customerName" class="form-control" placeholder="Ingresa el Nombre"
                                   required/>
                        </div>

                        <div class="mb-3">
                            <label for="customerLastName" class="form-label">Apellido</label>
                            <input name="customerLastName" class="form-control" placeholder="Ingresa el Apellido"
                                   required/>
                        </div>

                        <div class="mb-3">
                            <label for="customerEmail" class="form-label">Correo Electrónico</label>
                            <input type="email" name="customerEmail" class="form-control"
                                   placeholder="Ingresa el correo Electrónico"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" id="add-btn">Crear Pedido</button>
                            <button type="button" class="btn btn-success" id="edit-btn">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
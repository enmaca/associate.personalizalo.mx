<div>
@include('uxmal.table.listjs', ['table' => [
            'id' => 'orderListJS',
            'listjs' => [
                'attributes' => [
                   "data-listjs-value_names='" .json_encode([
                       'order_code',
                       'customer_name',
                       'customer_mobile',
                       'order_delivery_date'
                    ])."'"
                ]
            ],
            'header' => [
                'checkbok' => true,
                'columns' => [
                    [
                        'name' => 'order_code',
                        'label' => 'Código de pedido',
                        'sort' => true,
                        'filter' => true
                    ],
                    [
                        'name' => 'customer_name',
                        'label' => 'Nombre del cliente',
                        'sort' => true,
                        'filter' => true
                    ],
                    [
                        'name' => 'customer_mobile',
                        'label' => 'Celular',
                        'sort' => true,
                        'filter' => true
                    ],
                    [
                        'name' => 'order_delivery_date',
                        'label' => 'Fecha de Entrega',
                        'sort' => true,
                        'filter' => true
                    ],
                    [
                        'name' => 'order_status',
                        'label' => 'Estatus',
                        'sort' => true,
                        'filter' => true
                    ],
                    [
                        'name' => 'order_shipment_status',
                        'label' => 'Entrega',
                        'sort' => true,
                        'filter' => true
                    ],
                    [
                        'name' => 'order_address_book',
                        'label' => 'Dirección de Entrega'
                    ],
                    [
                        'name' => 'action',
                        'label' => ''
                    ]
                ]
            ],
            'top-buttons' => [
                [
                    'type' => 'button',
                    'class' => 'btn btn-success add-btn',
                    'onclick' => '',
                    'attributes' => [
                        'id="create-btn"',
                        'data-bs-toggle="modal"',
                        'data-bs-target="#createOrderModal"'
                    ],
                    'slot' => '<i class="ri-add-line align-bottom me-1"></i>Crear Pedido',
                ],
                [
                    'type' => 'button',
                    'class' => 'btn btn-soft-danger',
                    'onclick' => 'deleteMultiple()',
                    'slot' => '<i class="ri-delete-bin-2-line"></i>',
                ]
            ],
            'search' => [
                'placeholder' => 'Buscar...'
            ],
            'data' => $tableStruct['data']
    ]])


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
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-success" id="add-btn">Crear Pedido</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@pushonce('scripts')
    <script>
        function setValueDE(selector, value, enable){
            let inputE = document.querySelector(selector);
            inputE.value = value;
            //inputE.disabled = !enable;
        }
        document.addEventListener('livewire:initialized', () => {
            console.log('livewire:initialized');
            @this.on('change-customer-id', (event) => {
                console.log(event.data);
                enableFields = true;
                if (event.data.id != 'new')
                    enableFields = false;
                setValueDE('input[name=customerMobile]', event.data.mobile, enableFields);
                setValueDE('input[name=customerName]', event.data.name, enableFields);
                setValueDE('input[name=customerLastName]', event.data.last_name, enableFields);
                setValueDE('input[name=customerEmail]', event.data.email, enableFields);
            });
        });
    </script>
@endpushonce
@pushonce('scripts')
    @vite('resources/js/uxmal/list.js')
@endpushonce
@pushonce('onload-excute')
    if (window.init_listjs) { window.init_listjs(); }
@endpushonce


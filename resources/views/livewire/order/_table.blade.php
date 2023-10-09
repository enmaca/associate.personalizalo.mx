<div>
    @include('uxmal::components.html.listjs', ['table' => [
                'id' => 'orderListJS',
                'listjs' => [
                    'attributes' => [
                       "data-listjs-value_names='" .json_encode([
                           'chk_child',
                           'order_code',
                           'customer_name',
                           'customer_mobile',
                           'order_delivery_date'
                        ])."'",
                        'data-listjs-pagination=10'
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

    @include('uxmal::components.html.modal.bootstrap', [
        'data' => [
            'header' => [
                'label' => 'Crear Pedido',
                'row' => [

                ]
            ],
            'body' => [
                'form' => [
                    'id' => 'NewOrderFrom',
                    'class' => [],
                    'action' => route('orders_new'),
                    'method' => 'POST',
                    'elements' => [
                            'row' => [
                                'class' => [
                                    'col-6'
                                    ],
                                'elements' => [
                                    [
                                        'livewire' => 'client.search.select'
                                    ],
                                    [
                                        'uxmal' => 'input',
                                        'data' => [
                                            'field' => [
                                                'type' => 'text',
                                                'name' => 'customerMobile',
                                                'label' => 'Celular',
                                                'placeholder' => 'Ingresa Número de Celular',
                                                'required' => true
                                            ]
                                        ]
                                    ],
                                    [
                                        'uxmal' => 'input',
                                        'data' => [
                                            'field' => [
                                                'type' => 'text',
                                                'name' => 'customerName',
                                                'label' => 'Nombre',
                                                'placeholder' => 'Ingresa el Nombre',
                                                'required' => true
                                            ]
                                        ]
                                    ],
                                    [
                                        'uxmal' => 'input',
                                        'data' => [
                                            'field' => [
                                                'type' => 'text',
                                                'name' => 'customerLastName',
                                                'label' => 'Apellido',
                                                'placeholder' => 'Ingresa el Apellido',
                                                'required' => true
                                            ]
                                        ]
                                    ],
                                    [
                                        'uxmal' => 'input',
                                        'data' => [
                                            'field' => [
                                                'type' => 'text',
                                                'name' => 'customerEmail',
                                                'label' => 'Correo Electrónico',
                                                'placeholder' => 'Ingresa el Correo Electrónico',
                                                'required' => true
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                'footer' => [
                    'elements' => [
                        [
                            'uxmal' => 'button',
                            'data' => [
                                'type' => 'submit',
                                'class' => 'btn btn-success',
                                'onclick' => 'submitNewOrderFrom()',
                                'attributes' => [
                                    'id="add-btn"'
                                ],
                                'slot' => 'Crear Pedido',
                            ]
                        ]
                    ]
                ]
            ]
        ])
    @pushonce('scripts')
        <script>
            function setValueDE(selector, value, enable){
                let inputE = document.querySelector(selector);
                inputE.value = value;
                inputE.disabled = !enable;
            }
            function goToOrder( order_id ){
                window.location.href = '/orders/' + order_id;
            }
            function submitNewOrderFrom(){
                document.getElementById('NewOrderFrom').submit();
            }
        </script>
    @endpushonce
    @section("javascript")
        @pushonce('livewire:initialized')
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
            if (window.init_listjs) { window.init_listjs(); }
@endpushonce
@stop
@pushonce('scripts')
    @vite('resources/js/uxmal/list.js')
@endpushonce



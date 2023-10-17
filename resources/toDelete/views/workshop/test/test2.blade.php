@extends('workshop.test')
@section('title')
    @lang('translation.dashboards')
@endsection
@section('css')
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Modal Bootstrap</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    @php
                        $modalStruct = [
                            'row' => [
                                'elements' => [
                                    [
                                        'uxmal' => 'button',
                                        'data' => [
                                            'type' => 'button',
                                            'class' => 'btn btn-success add-btn',
                                            'onclick' => '',
                                            'attributes' => [
                                                'id="create-btn"',
                                                'data-bs-toggle="modal"',
                                                'data-bs-target="#createOrderModal"'
                                            ],
                                            'slot' => '<i class="ri-add-line align-bottom me-1"></i>Crear Pedido',
                                        ]
                                    ]
                                ]
                            ],
                            'modal' => [
                                'header' => [
                                    'label' => 'Crear Pedido',
                                    'row' => [

                                    ]
                                ],
                                'body' => [
                                    'form' => [
                                        'id' => 'NewOrderFrom',
                                        'class' => [],
                                        'action' => route('test'),
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
                                                    'onclick' => '',
                                                    'attributes' => [
                                                        'id="add-btn"'
                                                    ],
                                                    'slot' => 'Crear Pedido',
                                                ]
                                            ]
                                            ]
                                    ]
                                ]
                            ];
                    @endphp
                    @include('uxmal.route', ['data' => $modalStruct])
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end col -->
    </div>
@endsection


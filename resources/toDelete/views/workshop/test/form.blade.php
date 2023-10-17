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
                    <h4 class="card-title mb-0">Forms</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    @php
                        $formStruct = [
                            'form' => [
                                'id' => 'NewOrderFrom',
                                'class' => '',
                                'action' => route('test'),
                                'method' => 'POST',
                                'elements' => [
                                    'row' => [
                                        'class' => [
                                            'col-6'
                                            ],
                                        'elements' => [
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
                        ];
                    @endphp
                    @include('uxmal.form', [
                        'data' => $formStruct
                    ])
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end col -->
    </div>
@endsection
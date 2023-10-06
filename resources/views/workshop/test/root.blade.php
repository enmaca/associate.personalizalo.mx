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
                        $uxmal = new \App\Components\Uxmal\Uxmal();
                        $row = $uxmal->make('row');

                        $row->make('form.button', [
                            'class' => 'btn btn-success add-btn',
                            'onclick' => '',
                            'id' => 'create-btn',
                            'data-bs-toggle' => 'modal',
                            'data-bs-target' => '#createOrderModal',
                            'label' => 'Crear Pedido'
                            ]);


                        $form = new \App\Components\Uxmal\Form([
                            'id' => 'NewOrderFrom',
                            'class' => [],
                            'action' => route('test'),
                            'method' => 'POST']);

                        $form_row = $form->make('row', [
                            'class' => 'col-6'
                            ]);

                        $form_row->make('form.input', [
                            'type' => 'text',
                            'label' => 'Celular',
                            'input-attributes' => [
                                'name' => 'customerMobile',
                                'placeholder' => 'Ingresa Número de Celular',
                                'required' => true
                                ]
                            ]);

                        $form_row->make('form.input', [
                            'type' => 'text',
                            'label' => 'Nombre',
                            'input-attributes' => [
                                'name' => 'customerName',
                                'placeholder' => 'Ingresa el Nombre',
                                'required' => true
                                ]
                            ]);

                        $form_row->make('form.input', [
                            'type' => 'text',
                            'label' => 'Apellido',
                            'input-attributes' => [
                                'name' => 'customerLastName',
                                'placeholder' => 'Ingresa el Apellido',
                                'required' => true
                                ]
                            ]);

                         $form_row->make('form.input', [
                            'type' => 'text',
                            'label' => 'Correo Electrónico',
                            'input-attributes' => [
                                'name' => 'customerEmail',
                                'placeholder' => 'Ingresa el Correo Electrónico',
                                'required' => true
                                ]
                            ]);

                        $modal = $uxmal->make('modal', [
                            'class' => 'modal fade',
                             'id' => 'createOrderModal',
                            'header' => [
                                'label' => 'Crear Pedido'
                                ],
                            'body' => $form,
                            'footer' => [
                                'elements' => [
                                    [
                                        'form.button' => [
                                            'type' => 'submit',
                                            'class' => 'btn btn-success',
                                            'onclick' => '',
                                            'id' => 'add-btn',
                                            'slot' => 'Crear Pedido'
                                            ]
                                    ]
                                ]
                            ]
                        ]);
                    @endphp
                    @include('uxmal.route', [ 'data' => $uxmal->toArray() ])
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end col -->
    </div>
@endsection


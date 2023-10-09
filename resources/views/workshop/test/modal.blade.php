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
                    @include('uxmal.button.bootstrap', [
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
                    ])
                    @include('uxmal.modal.bootstrap', [

                    ])
                    @include('uxmal.form.input', [
                        'data' => [
                            'field' => [
                                'type' => 'text',
                                'name' => 'testId',
                                'label' => 'TestLabel',
                                'placeholder' => 'placeHolder_test',
                                'required' => true
                            ]
                        ]
                    ])

                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end col -->
    </div>
@endsection


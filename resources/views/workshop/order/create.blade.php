@extends('workshop.master')
@section('title')
    Listado de Pedidos
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Pedido {!! $order_code !!}</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <form>
                    <div class="row gy-4">
                            @csrf
                            <input type="hidden" name="orderId" value="{!! $order_id !!}">
                            <div class="col-xxl-3 col-md-6">
                                <div>
                                    <label for="customerName" class="form-label">Nombre del Cliente</label>
                                    <input name="customerName" class="form-control" id="customer-name-lastname" value="{!! $customer_name .' '.$customer_last_name !!}" disabled>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-md-6">
                                <div>
                                    <label for="customerMobile" class="form-label">Celular</label>
                                    <input class="form-control" id="customer-mobile" value="{!! $customer_mobile !!}" disabled>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-md-6">
                                <label for="customerEmail" class="form-label">Celular</label>
                                <div class="form-icon right">
                                    <input type="email" class="form-control" id="customer-email" value="{!! $customer_email !!}" disabled>
                                    <i class="ri-mail-unread-line"></i>
                                </div>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
            <!-- end col -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Materiales/Costos de Manufactura</h4>
                </div><!-- end card header -->
                <div class="card-body">

                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Productos</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="row gy-4">
                        <div class="col-md-6 col-sm-12">
                            @include('uxmal.forms.select_tomselect', [
                                'id' => 'productSelect',
                                'name' => 'productSelect',
                                'label' => 'Agregar Producto',
                                'data_choices_opts' => [],
                                'options' => $product_options,
                                'place_holder_option' => [
                                    'value' => 0,
                                    'name' => 'Seleccionar...'
                                    ],
                                'button' => [
                                    'id' => 'productSelected',
                                    'ri_icon' => 'add-fill'
                                    ]
                                ])
                        </div>
                    </div>
                    @livewire('order.create.products-table', ['orderId' => $order_id ])
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Adicionales</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="row gy-4">
                        <div class="col-md-6 col-sm-12">
                            @include('uxmal.forms.select_tomselect', [
                                'id' => 'materialSelect',
                                'name' => 'materialSelect',
                                'label' => 'Agregar Material Adicional',
                                'data_choices_opts' => [],
                                'options' => $material_options,
                                'place_holder_option' => [
                                    'value' => 0,
                                    'name' => 'Seleccionar...'
                                    ],
                                'button' => [
                                    'id' => 'meterialSelected',
                                    'ri_icon' => 'add-fill'
                                    ]
                                ])
                        </div>
                        <div class="col-md-6 col-sm-12">
                            @include('uxmal.forms.select_tomselect', [
                                'id' => 'laborCostSelect',
                                'name' => 'laborCostSelect',
                                'label' => 'Agregar Mano de Obra',
                                'data_choices_opts' => [],
                                'options' => $material_options,
                                'place_holder_option' => [
                                    'value' => 0,
                                    'name' => 'Seleccionar...'
                                    ],
                                'button' => [
                                    'id' => 'laborSelected',
                                    'ri_icon' => 'add-fill'
                                    ]
                                ])
                        </div>
                        <div class="col-md-6 col-sm-12">
                            @include('uxmal.forms.select_tomselect', [
                                'id' => 'mfgOverHeadSelect',
                                'name' => 'mfgOverHeadSelect',
                                'label' => 'Agregar Indirectos',
                                'data_choices_opts' => [],
                                'options' => $mfgoverhead_options,
                                'place_holder_option' => [
                                    'value' => 0,
                                    'name' => 'Seleccionar...'
                                    ],
                                'button' => [
                                    'id' => 'mfgOverHeadSelected',
                                    'ri_icon' => 'add-fill'
                                    ]
                                ])
                        </div>
                        <div class="col-md-6 col-sm-12">
                            @include('uxmal.forms.select_tomselect', [
                                'id' => 'mfgAreasSelect',
                                'name' => 'mfgAreasSelect',
                                'label' => 'Area de Manufactura',
                                'data_choices_opts' => [],
                                'options' => $mfgareas_options,
                                'place_holder_option' => [
                                    'value' => 0,
                                    'name' => 'Seleccionar...'
                                    ],
                                'button' => [
                                    'id' => 'mfgAreasSelected',
                                    'ri_icon' => 'add-fill'
                                    ]
                                ])
                        </div>
                    </div>
                    <div class="row gy-4">
                        <div class="col-3">
                            <button type="button" class="btn btn-primary">Agregar Arte Digital</button>
                        </div>
                        <div class="col-3">
                            <button type="button" class="btn btn-primary">Tipo de Impresión</button>
                        </div>
                    </div>
                    @livewire('order.create.dynamic-table', ['orderId' => $order_id ])
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
@endsection
@pushonce('scripts')
    <script>
        document.getElementById('productSelected').addEventListener('click', function() {
            console.log('productSelected Button was clicked!');
        });
        document.getElementById('meterialSelected').addEventListener('click', function() {
            console.log('meterialSelected Button was clicked!');
        });
        document.getElementById('laborSelected').addEventListener('click', function() {
            console.log('laborSelected Button was clicked!');
        });
        document.getElementById('mfgOverHeadSelected').addEventListener('click', function() {
            console.log('mfgOverHeadSelected Button was clicked!');
        });
    </script>
@endpushonce

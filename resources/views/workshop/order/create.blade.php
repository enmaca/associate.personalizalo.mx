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
                                    <input class="form-control" id="customer-name-lastname" value="{!! $customer_name .' '.$customer_last_name !!}" disabled>
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
                    <div class="row gy-4 d-flex align-items-end justify-content-center">
                        <div class="col-6">
                                @include('uxmal.forms.select_tomselect', [
                                    'id' => 'productSelect',
                                    'name' => 'productSelect',
                                    'label' => 'Seleccionar Producto',
                                    'data_choices_opts' => [],
                                    'options' => $product_options,
                                    'place_holder_option' => [
                                        'value' => 0,
                                        'name' => 'Selecciona un producto'
                                        ]
                                    ])
                        </div>
                        <div class="col-6">
                            <button type="button" style="margin-bottom: 15px" class="btn btn-outline-primary btn-icon"><i class="ri-add-fill"></i></button>
                        </div>
                    </div>
                    @livewire('order.create.products-table', ['orderId' => $order_id ])
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
@endsection

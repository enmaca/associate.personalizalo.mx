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
                    <div class="row gy-4">
                        <form>
                            @csrf
                            <input type="hidden" name="orderId" value="{!! $order_id !!}">
                            <div class="col-xxl-6 col-md-12">
                                <div>
                                    <label for="customerName" class="form-label">Nombre del Cliente</label>
                                    <input class="form-control" id="customer-name-lastname" value="{!! $customer_name .' '.$customer_lastname !!}" disabled>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-6 col-md-12">
                                <div>
                                    <label for="customerMobile" class="form-label">Celular</label>
                                    <input class="form-control" id="customer-mobile" value="{!! $customer_mobile !!}" disabled>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-md-12">
                                <div>
                                    <label for="customerEmail" class="form-label">Celular</label>
                                    <input type="email" class="form-control" id="customer-email" value="{!! $customer_email !!}" disabled>
                                    <i class="ri-mail-unread-line"></i>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end col -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Materiales/Costos de Manufactura</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="row gy-4">
                        <div class="col-xxl-6 col-md-12">
                            @include('uxmal.forms.select_choices', [
                                'id' => 'productSelect',
                                ''
                                ])
                        </div>
                    </div>
                    @livewire('order.create.manufacturing-costs-table')
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
@endsection

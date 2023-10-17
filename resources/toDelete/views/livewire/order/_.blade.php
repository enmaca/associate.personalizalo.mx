<div id="customerList" data-listjs>
    <div class="row g-4 mb-3">
        <div class="col-sm-auto">
            <div>
                <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn"
                        data-bs-target="#createOrderModal"><i class="ri-add-line align-bottom me-1"></i>Crear Pedido
                </button>
                <button class="btn btn-soft-danger" onClick="deleteMultiple()"><i class="ri-delete-bin-2-line"></i>
                </button>
            </div>
        </div>
        <div class="col-sm">
            <div class="d-flex justify-content-sm-end">
                <div class="search-box ms-2">
                    <input type="text" class="form-control search" placeholder="Search...">
                    <i class="ri-search-line search-icon"></i>
                </div>
            </div>
        </div>
    </div>

    <div id="customerDiv" class="table-responsive table-card mt-3 mb-1">
        <table class="table align-middle table-nowrap">
            <thead class="table-light">
            <tr>
                <th scope="col" style="width: 50px;">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                    </div>
                </th>
                <th data-header-field="order_code">C&oacute;digo de Pedido</th>
                <th class="sort" data-header-field="customer_name">Cliente</th>
                <th class="sort" data-header-field="customer_mobile">Celular</th>
                <th class="sort" data-header-field="order_delivery_date">Fecha de Entrega</th>
                <th class="sort" data-header-field="order_status">Estatus</th>
                <th class="sort" data-header-field="order_shipment_status">Entrega</th>
                <th data-header-field="order_address_book">Direcci&oacute;n de Entrega</th>
                <th data-sort="action">Action</th>
            </tr>
            </thead>
            <tbody class="list form-check-all">
            @foreach($orders as $order)
                <tr>
                    <th scope="row">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="chk_child"
                                   value="@hashid($order['id'])">
                        </div>
                    </th>
                    <td class="id" style="display:none;"><a href="javascript:void(0);" class="fw-medium link-primary">#VZ2101</a>
                    </td>
                    <td class="order_code">{{ $order['code'] }}</td>
                    <td class="customer_name">{{ $order['customer']['name']." ".$order['customer']['last_name'] }}</td>
                    <td class="customer_mobile">{{ $order['customer']['mobile'] }}</td>
                    <td class="order_delivery_date">{{ $order['delivery_date'] }}</td>
                    <td class="order_status"><span
                                class="badge text-success  bg-success-subtle text-uppercase">{{ $order_status_tr[$order['status']] }}</span>
                    </td>
                    <td class="order_shipment_status"><span
                                class="badge text-success  bg-success-subtle text-uppercase">{{ $shipment_status_tr[$order['shipment_status']] }}</span>
                    </td>
                    @php
                        $order_address_book = '';
                        if( !empty( $order['address'] ) ){
                            $order_address_book .= "Nombre: ".$order['address']['name']." ".$order['address']['last_name']."<br>";
                            $order_address_book .= "Tel&eacute;fono: ".$order['address']['contact_mobile']."<br>";
                            $order_address_book .= "Direccion:<br>".$order['address']['address_1']."<br>".$order['address']['address_2']."<br>".$order['address']['zip_code']."<br>";
                        }
                    @endphp
                    <td class="order_address_book">{!! $order_address_book !!}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <div class="edit">
                                <button class="btn btn-sm btn-primary edit-item-btn" data-bs-toggle="modal"
                                        data-bs-target="#showModal">Productos
                                </button>
                            </div>
                            <div class="remove">
                                <button class="btn btn-sm btn-primary remove-item-btn" data-bs-toggle="modal"
                                        data-bs-target="#deleteRecordModal">Cambiar Estatus
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="noresult" style="display: none">
            <div class="text-center">
                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                           colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                <h5 class="mt-2">Sin Resultados</h5>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end">
        <div class="pagination-wrap hstack gap-2">
            <a class="page-item pagination-prev disabled" href="#">
                Previous
            </a>
            <ul class="pagination listjs-pagination mb-0"></ul>
            <a class="page-item pagination-next" href="#">
                Next
            </a>
        </div>
    </div>
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
</div>
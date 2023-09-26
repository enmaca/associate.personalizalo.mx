<div id="customerList">
    <div class="row g-4 mb-3">
        <div class="col-sm-auto">
            <div>
                <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn"
                        data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Add
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

    <div class="table-responsive table-card mt-3 mb-1">
        <table class="table align-middle table-nowrap" id="customerTable">
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
                            <input class="form-check-input" type="checkbox" name="chk_child" value="option1">
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
                <h5 class="mt-2">Sorry! No Result Found</h5>
                <p class="text-muted mb-0">We've searched more than 150+ Orders We did not find any orders for you
                    search.</p>
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
    <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light p-3">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="close-modal"></button>
                </div>
                <form class="tablelist-form">
                    <div class="modal-body">
                        @livewire('client.search.select')

                        <div class="mb-3">
                            <label for="email-field" class="form-label">Email</label>
                            <input type="email" id="email-field" class="form-control" placeholder="Enter Email"
                                   required/>
                        </div>

                        <div class="mb-3">
                            <label for="phone-field" class="form-label">Phone</label>
                            <input type="text" id="phone-field" class="form-control" placeholder="Enter Phone no."
                                   required/>
                        </div>

                        <div class="mb-3">
                            <label for="date-field" class="form-label">Joining Date</label>
                            <input type="text" id="date-field" class="form-control" placeholder="Select Date" required/>
                        </div>

                        <div>
                            <label for="status-field" class="form-label">Status</label>
                            <select class="form-control" data-trigger name="status-field" id="status-field">
                                <option value="">Status</option>
                                <option value="Active">Active</option>
                                <option value="Block">Block</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" id="add-btn">Add Customer</button>
                            <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@section('script')
    <script src="{{ URL::asset('build/libs/list.js/list.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
@push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
        @this.on('change-customer-id', (event) => {
            console.log(event.data.id);
            });
        });
    </script>
@endpush

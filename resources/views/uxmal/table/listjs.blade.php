<div id="{!! $table['id'] !!}" data-listjs @isset($table['listjs']['attributes']) {!! join(" ", $table['listjs']['attributes']) !!} @endisset>
    <div class="row g-4 mb-3">
        <div class="col-sm-auto">
            <div>
                @isset($table['top-buttons'])
                    @foreach($table['top-buttons'] as $button_data)
                        @include('uxmal.button.bootstrap', ['data' => $button_data])
                    @endforeach
                @endisset
            </div>
        </div>
        <div class="col-sm">
            <div class="d-flex justify-content-sm-end">
                <div class="search-box ms-2">
                    @isset($table['search'])
                        <input
                                type="text"
                                id="{!! $table['id'] !!}Search"
                                class="form-control search"
                                @isset($table['search']['placeholder']) placeholder="{!! $table['search']['placeholder'] !!}" @endisset
                                @isset($table['search']['attributes']) {!! join( " ", $table['search']['attributes']) !!} @endisset>
                        <i class="ri-search-line search-icon"></i>
                    @endisset
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive table-card mt-3 mb-1">
        <table class="table align-middle table-nowrap" id="customerTable">
            <thead class="table-light">
            <tr>
                @isset($table['header']['checkbok'])
                    <th scope="col" style="width: 50px;">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="checkAll{!! $table['id'] !!}" value="all">
                        </div>
                    </th>
                @endisset
                @isset($table['header']['columns'])
                    @foreach($table['header']['columns'] as $th)
                        <th @isset($th['sort']) class="sort" data-sort="{!! $th['name'] !!}" @endisset>{!! $th['label'] !!}</th>
                    @endforeach
                @endisset
            </tr>
            </thead>
            <tbody class="list form-check-all">
                @foreach( $table['data'] as $td)
                    <tr>
                        @isset($table['header']['checkbok'])
                            <td scope="row">
                                <div class="form-check">
                                    <input class="chk_child form-check-input" type="checkbox" name="chk_child" data-check-id="{!! $td['id'] !!}">
                                </div>
                            </td>
                        @endisset
                        @foreach($table['header']['columns'] as $columns)
                            @if( $columns['name'] == 'action' && is_array($td[$columns['name']]) )
                                <td>
                                    <div class="d-flex gap-2">
                                    @foreach( $td[$columns['name']] as $td_button)
                                        <div class="{!! $td_button['name'] !!}">
                                            @include('uxmal.button.bootstrap', ['data' => $td_button['data']])
                                        </div>
                                    @endforeach
                                    </div>
                                </td>
                            @else
                                <td class="{!! $columns['name'] !!}">@if(strlen($td[$columns['name']]) !== strlen(htmlentities($td[$columns['name']], ENT_COMPAT | ENT_HTML401, 'UTF-8'))) {!! $td[$columns['name']] !!}@else {{ $td[$columns['name']] }}@endif</td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="noresult" style="display: none">
            <div class="text-center">
                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                <h5 class="mt-2">Sin Resultados</h5>
                <p class="text-muted mb-0">en {!! count($table['data']) !!} Registros.</p>
            </div>
        </div>
    </div>
    @isset($table['listjs']['attributes'])
        @php
            $has_pagination = false;
            if( is_array($table['listjs']['attributes']))
                foreach( $table['listjs']['attributes'] as $listjs_attr){
                    if( str_starts_with(trim($listjs_attr), 'data-listjs-pagination') ){
                        $has_pagination = true;
                        break;
                    }
                }

        @endphp
    @endisset
    @if($has_pagination == true)
        <div class="d-flex justify-content-end">
            <div class="pagination-wrap hstack gap-2">
                <a class="page-item pagination-prev disabled" href="#">
                    Anterior
                </a>
                <ul class="pagination listjs-pagination mb-0">
                    <!-- Pagination Starts Here -->
                </ul>
                <a class="page-item pagination-next" href="#">
                    Siguiente
                </a>
            </div>
        </div>
    @endif
</div>
@pushonce('scripts')
    @vite('resources/js/uxmal/list.js')
@endpushonce
@extends('workshop.master')
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
                    <h4 class="card-title mb-0">Listado de Clientes</h4>
                </div><!-- end card header -->
                <div class="card-body">
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end col -->
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection

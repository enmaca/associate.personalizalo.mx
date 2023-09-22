@extends('associates.master')
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
                    @livewire('client.table')
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end col -->
    </div>
@endsection
@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection

include(/Users/enriquemartinez/Documents/Proyectos/Personales/PHP/associate.personalizalo.mx/vendor/composer/../../app/Http/Controllers/Orders.php): Failed to open stream: No such file or directory



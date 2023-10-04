@extends('workshop.master')

@section('title', 'Fuentes')

@vite('resources/js/workshop/customizer/index.js')

@section('content')
<div class="row">
    <div class="col-12">
        <label class="w-100">
            Selecciona un archivo para el background
            <input id="bgSelector" class="form-control" type="file">
        </label>
    </div>
</div>
<div class="row mt-3">
    <div class="col-5">
        <div class="d-flex justify-content-end align-items-center mb-2 gap-2">
            Herramientas:
            <div class="btn-group" role="group">
                <input type="radio" class="btn-check" name="tool-mode" id="modeAdd" autocomplete="off" value="add" checked>
                <label class="btn btn-outline-primary" for="modeAdd" data-bs-toggle="tooltip" data-bs-title="Modo creación">
                    <i class="ph ph-selection-plus"></i>
                </label>
            
                <input type="radio" class="btn-check" name="tool-mode" id="modeSelect" autocomplete="off" value="select">
                <label class="btn btn-outline-primary d-flex align-items-center" for="modeSelect" data-bs-toggle="tooltip" data-bs-title="Modo selección">
                    <i class="ph ph-selection"></i>
                </label>
            </div>
        </div>
        <div id="customizator"></div>
    </div>
    <div class="col-7">
        Menu
    </div>
</div>
@endsection
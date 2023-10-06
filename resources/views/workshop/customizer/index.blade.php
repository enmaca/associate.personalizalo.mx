@extends('workshop.master')

@section('title', 'Personalizador')

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
                    <i class="ph ph-hand-pointing"></i>
                </label>
            </div>
        </div>
        <div id="customizator"></div>
    </div>
    <div class="col-7">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active d-flex align-items-center" id="layerTab" data-bs-toggle="tab" data-bs-target="#layerTabPane" type="button" role="tab" aria-controls="layerTabPane" aria-selected="true">
                    <i class="ph ph-stack"></i>
                    <span class="ms-2">Layers</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link d-flex align-items-center" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settingsTabPane" type="button" role="tab" aria-controls="settingsTabPane" aria-selected="false">
                    <i class="ph ph-gear"></i>
                    <span class="ms-2">Configuración</span>
                </button>
            </li>
        </ul>
        <div class="tab-content">
            <div x-data class="tab-pane fade show active" id="layerTabPane" role="tab-panel" aria-labelledby="layerTab" tabindex="0">
                <ul class="list-group">
                    <template x-for="(item, index) in $store.customizationData.items" :key="item.id">
                        <template x-if="index > 0">
                            <li href="#" class="list-group-item d-flex justify-content-between align-items-center" :class="$store.customizationData.selected === item.id ? 'active' : ''">
                                <button class="btn btn-sm btn-info" x-on:click="$store.customizationData.setSelected(item.id)">
                                    <i class="ph ph-hand-pointing"></i>
                                </button>
                                <div class="flex-grow-1 ms-2" x-text="item.id"></div>
                                <button class="btn btn-sm btn-danger" x-on:click="$store.customizationData.remove(item.id)">
                                    <i class="ph ph-trash"></i>
                                </button>
                            </li>
                        </template>
                    </template>
                </ul>
            </div>
            <div class="tab-pane fade" id="settingsTabPane" role="tab-panel" aria-labelledby="settings-tab" tabindex="0">
                settings
            </div>
        </div>
    </div>
</div>
@endsection
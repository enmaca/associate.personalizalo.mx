<?php

namespace App\Support\UxmalComponents\Material;

class ModalAddToOrder extends \Enmaca\LaravelUxmal\Abstract\Modal
{

    public function build()
    {
        $aggregate = [];
        if( isset($this->attributes['options']['saveBtn.onclick']) )
            $aggregate['modal.saveBtn.onclick'] = $this->attributes['options']['saveBtn.onclick'];

        $modal = \Enmaca\LaravelUxmal\Uxmal::component('ui.modal', [
            'options' => [
                'modal.name' => 'selectedMaterialToAddToOrder',
                'modal.title' => 'Agregar Material Directo',
                'modal.body' => \Enmaca\LaravelUxmal\Uxmal::component('livewire', [
                    'path' => 'material.modal.add-material-to-order'
                ]),
                'modal.saveBtn.label' => 'Agregar al Pedido',
                'modal.size' => 'normal'
            ] + $aggregate
        ]);

        switch ($this->attributes['context']) {
            default:
                $this->_callBtn = $modal->getShowButton([
                    'options' => [
                        'button.name' => 'showModalSelectedMaterialToAddToOrder',
                        'button.label' => 'Mostrar'
                    ]], 'object');
                break;
        }

        $this->_content = $modal;

    }
}

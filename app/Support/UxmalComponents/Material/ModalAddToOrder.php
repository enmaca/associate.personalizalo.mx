<?php

namespace App\Support\UxmalComponents\Material;

class ModalAddToOrder extends \Enmaca\LaravelUxmal\Abstract\ModalBlock
{

    public function build()
    {
        $aggregate = [];
        if( isset($this->attributes['options']['saveBtn.onclick']) )
            $aggregate['modal.saveBtn.onclick'] = $this->attributes['options']['saveBtn.onclick'];

        $modal = \Enmaca\LaravelUxmal\UxmalComponent::Make('ui.modal', [
            'options' => [
                'modal.name' => 'selectedMaterialToAddToOrder',
                'modal.title' => 'Agregar Material Directo',
                'modal.body' => \Enmaca\LaravelUxmal\UxmalComponent::Make('livewire', [
                    'path' => 'material.modal.add-material-to-order'
                ]),
                'modal.saveBtn.label' => 'Agregar al Pedido',
                'modal.size' => 'normal'
            ] + $aggregate
        ]);

        switch ($this->GetContext()) {
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

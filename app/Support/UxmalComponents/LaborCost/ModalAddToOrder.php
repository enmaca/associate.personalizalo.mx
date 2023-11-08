<?php

namespace App\Support\UxmalComponents\LaborCost;

class ModalAddToOrder extends \Enmaca\LaravelUxmal\Abstract\Modal
{

    public function build()
    {
        $aggregate = [];
        if( isset($this->attributes['options']['saveBtn.onclick']) )
            $aggregate['modal.saveBtn.onclick'] = $this->attributes['options']['saveBtn.onclick'];

        $modal = \Enmaca\LaravelUxmal\Uxmal::component('ui.modal', [
            'options' => [
                    'modal.name' => 'selectedLaborCostToAddToOrder',
                    'modal.title' => 'Agregar Mano de Obra',
                    'modal.body' => \Enmaca\LaravelUxmal\Uxmal::component('livewire', [
                        'path' => 'laber_cost.modal.add-labor-cost-to-order'
                    ]),
                    'modal.saveBtn.label' => 'Agregar al Pedido',
                    'modal.size' => 'normal'
                ] + $aggregate
        ]);

        switch ($this->GetContext()) {
            default:
                $this->_callBtn = $modal->getShowButton([
                    'options' => [
                        'button.name' => 'showModalSelectedLaborCostToAddToOrder',
                        'button.label' => 'Mostrar'
                    ]], 'object');
                break;
        }

        $this->_content = $modal;

    }
}

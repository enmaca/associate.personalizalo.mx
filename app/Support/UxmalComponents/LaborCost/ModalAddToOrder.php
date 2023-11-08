<?php

namespace App\Support\UxmalComponents\LaborCost;

use Enmaca\LaravelUxmal\Abstract\ModalBlock;
use Enmaca\LaravelUxmal\UxmalComponent;
use Exception;

class ModalAddToOrder extends ModalBlock
{

    /**
     * @throws Exception
     */
    public function build(): void
    {
        $aggregate = [];
        if( isset($this->attributes['options']['saveBtn.onclick']) )
            $aggregate['modal.saveBtn.onclick'] = $this->attributes['options']['saveBtn.onclick'];

        $modal = UxmalComponent::Make('ui.modal', [
            'options' => [
                    'modal.name' => 'selectedLaborCostToAddToOrder',
                    'modal.title' => 'Agregar Mano de Obra',
                    'modal.body' => UxmalComponent::Make('livewire', [
                        'path' => 'labor_cost.modal.add-labor-cost-to-order'
                    ]),
                    'modal.saveBtn.label' => 'Agregar al Pedido',
                    'modal.size' => 'normal'
                ] + $aggregate
        ]);

        $this->_callBtn = match ($this->GetContext()) {
            default => $modal->getShowButton([
                'options' => [
                    'button.name' => 'showModalSelectedLaborCostToAddToOrder',
                    'button.label' => 'Mostrar'
                ]], 'object'),
        };

        $this->_content = $modal;

    }
}

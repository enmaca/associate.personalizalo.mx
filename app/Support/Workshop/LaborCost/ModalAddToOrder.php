<?php

namespace App\Support\Workshop\LaborCost;

use Enmaca\LaravelUxmal\Abstract\ModalBlock;
use Enmaca\LaravelUxmal\Components\Ui\Modal;
use Enmaca\LaravelUxmal\Support\Options\Form\ButtonOptions;
use Enmaca\LaravelUxmal\Support\Options\Ui\ModalOptions;
use Enmaca\LaravelUxmal\UxmalComponent;
use Exception;

class ModalAddToOrder extends ModalBlock
{

    /**
     * @throws Exception
     */
    public function build(): void
    {
        $modal = Modal::Options(new ModalOptions(
            name: 'selectedLaborCostToAddToOrder',
            size: 'normal',
            title: 'Agregar Mano de Obra',
            body: UxmalComponent::Make('livewire', [
                'path' => 'labor_cost.modal.add-labor-cost-to-order'
            ]),
            saveBtnLabel: 'Agregar al Pedido',
            saveBtnOnClick: $this->GetOption('saveBtn.onclick') ?? null
        ));

        $this->_callBtn = match ($this->GetContext()) {
            default => $modal->getShowButton(new ButtonOptions(label: 'Mostrar', name: 'showModalSelectedLaborCostToAddToOrder'), 'object')
        };

        $this->_content = $modal;

    }
}

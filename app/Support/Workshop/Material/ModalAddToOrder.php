<?php

namespace App\Support\Workshop\Material;

use Enmaca\LaravelUxmal\Components\Form\Button;
use Enmaca\LaravelUxmal\Components\Ui\Modal;
use Enmaca\LaravelUxmal\Support\Options\Form\ButtonOptions;
use Enmaca\LaravelUxmal\Support\Options\Ui\ModalOptions;
use Enmaca\LaravelUxmal\UxmalComponent;
use Exception;

class ModalAddToOrder extends \Enmaca\LaravelUxmal\Abstract\ModalBlock
{
    /**
     * @return void
     * @throws Exception
     */
    public function build(): void
    {
        $modal = Modal::Options(new ModalOptions(
            name: 'selectedMaterialToAddToOrder',
            size: 'normal',
            title: 'Agregar Material Directo',
            body: UxmalComponent::Make('livewire', [
                'path' => 'material.modal.add-material-to-order'
            ]),
            saveBtnLabel: 'Agregar al Pedido',
            saveBtnOnClick: $this->GetOption('saveBtn.onclick') ?? null
        ));

        $this->_callBtn = match ($this->GetContext()) {
            default => $modal->getShowButton( new ButtonOptions( name: 'showModalSelectedMaterialToAddToOrder', label: 'Mostrar'), 'object'),
        };

        $this->SetContent($modal);

    }
}

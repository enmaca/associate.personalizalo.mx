<?php

namespace App\Support\Workshop\Material;

use Enmaca\LaravelUxmal\Block\ModalBlock;
use Enmaca\LaravelUxmal\Components\Livewire;
use Enmaca\LaravelUxmal\Components\Ui\Modal;
use Enmaca\LaravelUxmal\Support\Options\Form\ButtonOptions;
use Enmaca\LaravelUxmal\Support\Options\LivewireOptions;
use Enmaca\LaravelUxmal\Support\Options\Ui\ModalOptions;
use Exception;

class ModalAddToOrder extends ModalBlock
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
            body: Livewire::Options(new LivewireOptions(
                path: 'material.modal.add-material-to-order',
                appendData: [
                    'order_hashId' => $this->GetValue('order_id')
                ]
            )),
            saveBtnLabel: 'Agregar al Pedido',
            saveBtnOnClick: $this->GetOption('saveBtn.onclick') ?? null
        ));

        $this->_callBtn = match ($this->GetContext()) {
            default => $modal->getShowButton( new ButtonOptions(
                label: 'Mostrar',
                name: 'showModalSelectedMaterialToAddToOrder'), 'object'),
        };

        $this->SetContent($modal);

    }
}

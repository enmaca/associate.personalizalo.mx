<?php

namespace App\Support\Workshop\Products;

use Enmaca\LaravelUxmal\Abstract\ModalBlock;
use Enmaca\LaravelUxmal\Components\Form\Button;
use Enmaca\LaravelUxmal\Components\Ui\Modal;
use Enmaca\LaravelUxmal\Support\Options\Form\ButtonOptions;
use Enmaca\LaravelUxmal\Support\Options\Ui\ModalOptions;
use Enmaca\LaravelUxmal\UxmalComponent;
use Exception;

class ModalSelectProductWithDigitalArt extends ModalBlock
{

    /**
     * @throws Exception
     */
    public function build(): void
    {
        $modal = Modal::Options(new ModalOptions(
            name: 'selectProductWithDigitalArt',
            size: 'large',
            title: 'Agregar Producto (Arte Digital)',
            body: UxmalComponent::Make('livewire', [
                'path' => 'products.modal.select-by-digital-art-body'
            ]),
            saveBtnLabel: 'Agregar al Pedido',
            saveBtnOnClick: $this->GetOption('saveBtn.onclick') ?? null
        ));

        $this->_callBtn = match ($this->GetContext()) {
            default => $modal->getShowButton( new ButtonOptions( label: 'Mostrar', name: 'showModalSelectProductWithDigitalArt'), 'object')
        };
        $this->_content = $modal;
    }
}

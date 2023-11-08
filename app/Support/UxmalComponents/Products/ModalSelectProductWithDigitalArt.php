<?php

namespace App\Support\UxmalComponents\Products;

use Enmaca\LaravelUxmal\Abstract\ModalBlock;
use Enmaca\LaravelUxmal\UxmalComponent;
use Exception;

class ModalSelectProductWithDigitalArt extends ModalBlock
{

    /**
     * @throws Exception
     */
    public function build(): void
    {
        $aggregate = [];
        if( $this->GetOption('saveBtn.onclick') )
            $aggregate['modal.saveBtn.onclick'] = $this->GetOption('saveBtn.onclick');

        $modal = UxmalComponent::Make('ui.modal', [
            'options' => [
                'modal.name' => 'selectProductWithDigitalArt',
                'modal.title' => 'Agregar Producto (Arte Digital)',
                'modal.body' => UxmalComponent::Make('livewire', [
                    'path' => 'products.modal.select-by-digital-art-body'
                ]),
                'modal.saveBtn.label' => 'Agregar al Pedido',
                'modal.size' => 'large'
            ] + $aggregate
        ]);

        $this->_callBtn = match ($this->GetContext()) {
            default => $modal->getShowButton([
                'options' => [
                    'button.name' => 'showModalSelectProductWithDigitalArt',
                    'button.label' => 'Mostrar'
                ]], 'object'),
        };
        $this->_content = $modal;
    }
}

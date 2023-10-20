<?php

namespace App\Support\UxmalComponents\Products;

class ModalSelectProductWithDigitalArt extends \Enmaca\LaravelUxmal\Abstract\Modal
{

    public function build()
    {
        $modal = \Enmaca\LaravelUxmal\Uxmal::component('ui.modal', [
            'options' => [
                'modal.name' => 'selectProductWithDigitalArt',
                'modal.title' => 'Agregar Producto (Arte Digital)',
                'modal.body' => \Enmaca\LaravelUxmal\Uxmal::component('livewire', [
                    'path' => 'products.modal.select-by-digital-art-body'
                ]),
                'modal.saveBtn.label' => 'Agregar al Pedido',
                'modal.saveBtn.onclick' => 'addProductToOrder()',
                'modal.size' => 'large'
            ]
        ]);

        switch ($this->attributes['context']) {
            default:
                $this->_callBtn = $modal->getShowButton([
                    'options' => [
                        'button.name' => 'showModalProductWithDigitalArt',
                        'button.label' => 'Mostrar'
                    ]], 'object');
                break;
        }

        $this->_content = $modal;

    }
}

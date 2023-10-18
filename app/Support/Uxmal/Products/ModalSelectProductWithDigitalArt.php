<?php

namespace App\Support\Uxmal\Products;

class ModalSelectProductWithDigitalArt extends \Enmaca\LaravelUxmal\Abstract\Modal
{

    public function build()
    {
        $modal = \Enmaca\LaravelUxmal\Uxmal::component('ui.modal', [
            'options' => [
                'name' => 'selectProductWithDigitalArt',
                'title' => 'Agregar Producto (Arte Digital)',
                'body' => \Enmaca\LaravelUxmal\Uxmal::component('livewire', [
                    'path' => 'products.modal.select-by-digital-art-body'
                ]),
                'saveBtn' => [
                    'label' => 'Agregar al Pedido',
                    'onclick' => 'addProductToOrder()'
                ]
            ]
        ]);

        switch($this->attributes['context']){
            default:
                $this->_callBtn =  $modal->getShowButton([
                    'options' => [
                        'label' => 'Mostrar'
                    ]], 'object');
                break;
        }

        $this->_content = $modal;

    }
}

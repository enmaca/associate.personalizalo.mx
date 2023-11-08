<?php

namespace App\Support\UxmalComponents\Products;

class ModalSelectProductWithDigitalArt extends \Enmaca\LaravelUxmal\Abstract\Modal
{

    public function build()
    {
        $aggregate = [];
        if( isset($this->attributes['options']['saveBtn.onclick']) )
            $aggregate['modal.saveBtn.onclick'] = $this->attributes['options']['saveBtn.onclick'];

        $modal = \Enmaca\LaravelUxmal\Uxmal::component('ui.modal', [
            'options' => [
                'modal.name' => 'selectProductWithDigitalArt',
                'modal.title' => 'Agregar Producto (Arte Digital)',
                'modal.body' => \Enmaca\LaravelUxmal\Uxmal::component('livewire', [
                    'path' => 'products.modal.select-by-digital-art-body'
                ]),
                'modal.saveBtn.label' => 'Agregar al Pedido',
                'modal.size' => 'large'
            ] + $aggregate
        ]);

        switch ($this->GetContext()) {
            default:
                $this->_callBtn = $modal->getShowButton([
                    'options' => [
                        'button.name' => 'showModalSelectProductWithDigitalArt',
                        'button.label' => 'Mostrar'
                    ]], 'object');
                break;
        }

        $this->_content = $modal;

    }
}

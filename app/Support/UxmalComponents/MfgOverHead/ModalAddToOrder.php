<?php

namespace App\Support\UxmalComponents\MfgOverHead;

class ModalAddToOrder extends \Enmaca\LaravelUxmal\Abstract\Modal
{

    public function build()
    {
        $aggregate = [];
        if( isset($this->attributes['options']['saveBtn.onclick']) )
            $aggregate['modal.saveBtn.onclick'] = $this->attributes['options']['saveBtn.onclick'];

        $modal = \Enmaca\LaravelUxmal\Uxmal::component('ui.modal', [
            'options' => [
                'modal.name' => 'selectedMfgOverHeadToAddToOrder',
                'modal.title' => 'Costos Indirectos',
                'modal.body' => \Enmaca\LaravelUxmal\Uxmal::component('livewire', [
                    'path' => 'mfg-over-head.modal.add-mfg-overhead-to-order'
                ]),
                'modal.saveBtn.label' => 'Agregar al Pedido',
                'modal.size' => 'normal'
            ] + $aggregate
        ]);

        switch ($this->GetContext()) {
            default:
                $this->_callBtn = $modal->getShowButton([
                    'options' => [
                        'button.name' => 'showModalSelectedMfgOverHeadToAddToOrder',
                        'button.label' => 'Mostrar'
                    ]], 'object');
                break;
        }

        $this->_content = $modal;

    }
}

<?php

namespace App\Support\UxmalComponents\Material;

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
        $aggregate = [];
        if( isset($this->attributes['options']['saveBtn.onclick']) )
            $aggregate['modal.saveBtn.onclick'] = $this->attributes['options']['saveBtn.onclick'];

        $modal = UxmalComponent::Make('ui.modal', [
            'options' => [
                'modal.name' => 'selectedMaterialToAddToOrder',
                'modal.title' => 'Agregar Material Directo',
                'modal.body' => UxmalComponent::Make('livewire', [
                    'path' => 'material.modal.add-material-to-order'
                ]),
                'modal.saveBtn.label' => 'Agregar al Pedido',
                'modal.size' => 'normal'
            ] + $aggregate
        ]);

        $this->_callBtn = match ($this->GetContext()) {
            default => $modal->getShowButton([
                'options' => [
                    'button.name' => 'showModalSelectedMaterialToAddToOrder',
                    'button.label' => 'Mostrar'
                ]], 'object'),
        };

        $this->SetContent($modal);

    }
}

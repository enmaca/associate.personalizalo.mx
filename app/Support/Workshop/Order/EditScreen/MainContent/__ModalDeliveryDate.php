<?php

namespace App\Support\Workshop\Order\EditScreen\MainContent;

use Illuminate\Support\Str;

class ModalDeliveryDate extends \Enmaca\LaravelUxmal\Abstract\Modal
{

    public function build()
    {
        $aggregate = [];
        if( isset($this->attributes['options']['saveBtn.onclick']) )
            $aggregate['modal.saveBtn.onclick'] = $this->attributes['options']['saveBtn.onclick'];

        $selectDate = \Enmaca\LaravelUxmal\Components\Form\Input::Options([
            'input.type' => 'text',
            'input.label' => '',
            'input.name' => 'orderDeliveryDate',
            'input.value' => $this->attributes['values'][str::snake('customerLastName')] ?? '',
            'input.required' => true
        ]);

        $modal = \Enmaca\LaravelUxmal\UxmalComponent::Make('ui.modal', [
            'options' => [
                    'modal.name' => 'selectOrderDeliveryDate',
                    'modal.title' => 'Fecha de Entrega',
                    'modal.body' => $selectDate,
                    'modal.saveBtn.label' => 'Agregar al Pedido',
                    'modal.size' => 'normal'
                ] + $aggregate
        ]);

        switch ($this->attributes['context']) {
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

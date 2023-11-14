<?php

namespace App\Support\Workshop\MfgOverHead;

use Enmaca\LaravelUxmal\Abstract\ModalBlock;
use Enmaca\LaravelUxmal\Components\Form\Button;
use Enmaca\LaravelUxmal\Components\Ui\Modal;
use Enmaca\LaravelUxmal\Support\Options\Form\ButtonOptions;
use Enmaca\LaravelUxmal\Support\Options\Ui\ModalOptions;
use Enmaca\LaravelUxmal\UxmalComponent;
use Exception;

class ModalAddToOrder extends ModalBlock
{

    /**
     * @throws Exception
     */
    public function build(): void
    {
        $aggregate = [];
        if( isset($this->attributes['options']['saveBtn.onclick']) )
            $aggregate['modal.saveBtn.onclick'] = $this->attributes['options']['saveBtn.onclick'];

        $modal = Modal::Options(new ModalOptions(
            name: 'selectedMfgOverHeadToAddToOrder',
            size: 'normal',
            title: 'Costos Indirectos',
            body: UxmalComponent::Make('livewire', [
                'path' => 'mfg-over-head.modal.add-mfg-overhead-to-order'
            ]),
            saveBtnLabel: 'Agregar al Pedido',
            saveBtnOnClick: $this->GetOption('saveBtn.onclick') ?? null
        ));

        $this->_callBtn = match ($this->GetContext()) {
            default => $modal->getShowButton( new ButtonOptions( label: 'Mostrar', name: 'showModalSelectedMfgOverHeadToAddToOrder'), 'object')
        };

        $this->_content = $modal;

    }
}

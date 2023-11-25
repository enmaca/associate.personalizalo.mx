<?php

namespace App\Support\Workshop\Order;

use App\Support\Workshop\LaborCost\ModalAddToOrder as LaborCostModalAddToOrder;
use App\Support\Workshop\Material\ModalAddToOrder as MaterialModalAddToOrder;
use App\Support\Workshop\MfgOverHead\ModalAddToOrder as MfgOverHeadModalAddToOrder;
use App\Support\Workshop\OrderProductDynamicDetails\OPDDModalCreateNew;
use App\Support\Workshop\Products\ModalSelectProductWithDigitalArt;

use Enmaca\LaravelUxmal\Block\ScreenBlock;
use Enmaca\LaravelUxmal\Components\Form\Button;
use Enmaca\LaravelUxmal\Components\Ui\Row;
use Enmaca\LaravelUxmal\Support\Options\Form\ButtonOptions;
use Enmaca\LaravelUxmal\Support\Options\Ui\RowOptions;
use Illuminate\Support\Facades\View;

class EditScreen extends ScreenBlock
{

    /**
     * @throws \Exception
     */
    public function build(): void
    {
        $orderCode = 'Pedido ' . $this->GetValue('order_code');
        $validateButton = Button::Options(new ButtonOptions(
            name: 'validateOrderButton',
            label: 'Validar Pedido',
            style: 'success'
        ))->toHtml();

        $Header =<<<HTML
<div class="text-start w-75 ps-5"><h3>{$orderCode}</h3></div>
<div class="text-end w-25 pe-5">{$validateButton}</div>
HTML;

        $this->SetTopBarHeader(Row::Options(new RowOptions(
            replaceAttributes: [
                'class' => 'd-flex align-items-center w-100'
            ],
            content: $Header
        ))->toHtml());

        $this->SetMainContent(EditScreen\MainContent::Object(values: $this->GetValues()));
        /**
         * Add Modals
         */
        $this->addModal(OPDDModalCreateNew::Modal(values: $this->GetValues()));
        $this->addModal(MaterialModalAddToOrder::Modal(values: $this->GetValues()));
        $this->addModal(LaborCostModalAddToOrder::Modal(values: $this->GetValues()));
        $this->addModal(MfgOverHeadModalAddToOrder::Modal(values: $this->GetValues()));
        $this->addModal(ModalSelectProductWithDigitalArt::Modal(values: $this->GetValues()));
    }
}
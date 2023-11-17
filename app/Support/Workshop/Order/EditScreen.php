<?php

namespace App\Support\Workshop\Order;

use App\Support\Workshop\LaborCost\ModalAddToOrder as LaborCostModalAddToOrder;
use App\Support\Workshop\Material\ModalAddToOrder as MaterialModalAddToOrder;
use App\Support\Workshop\MfgOverHead\ModalAddToOrder as MfgOverHeadModalAddToOrder;
use App\Support\Workshop\OrderProductDynamicDetails\OPDDModalCreateNew;
use App\Support\Workshop\Products\ModalSelectProductWithDigitalArt;

use Enmaca\LaravelUxmal\Abstract\ScreenBlock;

class EditScreen extends ScreenBlock
{

    public function build(): void
    {
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
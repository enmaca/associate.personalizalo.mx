<?php
namespace App\Support\Workshop\Order;

use Enmaca\LaravelUxmal\Abstract\ScreenBlock;

class EditScreen extends ScreenBlock
{

    public function build(): void
    {
       $this->SetMainContent(EditScreen\MainContent::Object(values: $this->GetValues()));
        /**
         * Add Modals
         */
        $this->addModal(\App\Support\Workshop\Material\ModalAddToOrder::Modal());
        $this->addModal(\App\Support\Workshop\LaborCost\ModalAddToOrder::Modal());
        $this->addModal(\App\Support\Workshop\MfgOverHead\ModalAddToOrder::Modal());
        $this->addModal(\App\Support\Workshop\Products\ModalSelectProductWithDigitalArt::Modal());
    }
}
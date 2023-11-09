<?php
namespace App\Support\UxmalComponents\Order;

use Enmaca\LaravelUxmal\Abstract\ScreenBlock;

class EditScreen extends ScreenBlock
{

    public function build(): void
    {
       $this->SetMainContent(EditScreen\MainContent::Object(values: $this->GetValues()));
        /**
         * Add Modals
         */
        $this->addModal(\App\Support\UxmalComponents\Material\ModalAddToOrder::Modal());
        $this->addModal(\App\Support\UxmalComponents\LaborCost\ModalAddToOrder::Modal());
        $this->addModal(\App\Support\UxmalComponents\MfgOverHead\ModalAddToOrder::Modal());
        $this->addModal(\App\Support\UxmalComponents\Products\ModalSelectProductWithDigitalArt::Modal());
    }
}
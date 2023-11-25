<?php
namespace App\Support\Workshop\Order;

use Enmaca\LaravelUxmal\Block\ScreenBlock;

class Dashboard extends ScreenBlock
{

    public function build(): void
    {
        $this->SetMainContent(Dashboard\MainContent::Object() );
        $this->addModal(\App\Support\Workshop\Customer\ModalSearchByMobile::Modal(context: 'createorder'));
    }
}
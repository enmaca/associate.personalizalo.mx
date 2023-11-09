<?php
namespace App\Support\UxmalComponents\Order;

use Enmaca\LaravelUxmal\Abstract\ScreenBlock;

class Dashboard extends ScreenBlock
{

    public function build(): void
    {
        $this->SetMainContent(Dashboard\MainContent::Object() );
        $this->addModal(\App\Support\UxmalComponents\Customer\ModalSearchByMobile::Object(['context' => 'createorder']));
    }
}
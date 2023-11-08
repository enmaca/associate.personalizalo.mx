<?php
namespace App\Support\UxmalComponents\Order;

class Dashboard extends \Enmaca\LaravelUxmal\Abstract\Screen
{

    public function build(): void
    {
        $this->SetMainContent(Dashboard\MainContent::Object() );
        $this->addModal(\App\Support\UxmalComponents\Customer\ModalSearchByMobile::Object(['context' => 'createorder']));
    }
}
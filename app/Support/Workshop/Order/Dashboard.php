<?php
namespace App\Support\Workshop\Order;

use App\Support\Workshop\Customer\ModalSearchByMobile;
use Enmaca\LaravelUxmal\Block\ScreenBlock;

class Dashboard extends ScreenBlock
{

    public function build(): void
    {
        $this->SetMainContent(Dashboard\MainContent::Object());

        $this->addModal(ModalSearchByMobile::Modal(context: 'createorder'));
    }
}
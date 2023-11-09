<?php

namespace App\Support\UxmalComponents\Order\EditScreen\MainContent;

use App\Support\UxmalComponents\MfgArea\SelectByName as SelectByNameMfgArea;
use App\Support\UxmalComponents\MfgDevices\SelectByName as SelectByNameMfgDevices;
use Illuminate\Support\Str;

class MfgCard extends \Enmaca\LaravelUxmal\Abstract\CardBlock
{
    /**
     * @throws \Exception
     */
    public function build(): void
    {
        $this->BodyRow();
        $this->BodyInput(SelectByNameMfgArea::Object());
        $this->BodyInput(SelectByNameMfgDevices::Object());
    }
}
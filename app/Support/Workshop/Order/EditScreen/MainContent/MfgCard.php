<?php

namespace App\Support\Workshop\Order\EditScreen\MainContent;

use App\Support\Workshop\MfgArea\SelectByName as SelectByNameMfgArea;
use App\Support\Workshop\MfgDevices\SelectByName as SelectByNameMfgDevices;
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
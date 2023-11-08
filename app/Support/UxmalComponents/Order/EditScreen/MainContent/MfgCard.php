<?php

namespace App\Support\UxmalComponents\Order\EditScreen\MainContent;

use Illuminate\Support\Str;

class MfgCard extends \Enmaca\LaravelUxmal\Abstract\Card
{

    public function build()
    {

        $this->BodyRow();

        $search_mfg_area_tomselect = \App\Support\UxmalComponents\MfgArea\SelectByName::Object();
        $this->BodyInput($search_mfg_area_tomselect);

        $search_mfg_devices_tomselect = \App\Support\UxmalComponents\MfgDevices\SelectByName::Object();
        $this->BodyInput($search_mfg_devices_tomselect);
    }

}
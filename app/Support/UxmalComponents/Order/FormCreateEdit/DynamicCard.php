<?php

namespace App\Support\UxmalComponents\Order\FormCreateEdit;

use Illuminate\Support\Str;

class DynamicCard extends \Enmaca\LaravelUxmal\Abstract\Card
{

    public function build()
    {
        $this->BodyRow();

        $this->setBodyFieldRowClass('col-xxl-6 mb-3');

        $search_product_tomselect = \App\Support\UxmalComponents\Material\SelectByNameSkuDesc::Object(['options' => ['event-change-handler' => 'onChangeSelectedMaterialByNameSkuDesc']]);
        $this->BodyInput($search_product_tomselect);

        $search_labor_cost_tomselect = \App\Support\UxmalComponents\LaborCost\SelectByName::Object(['options' => ['event-change-handler' => 'onChangeSelectedLaborCostByName']]);
        $this->BodyInput($search_labor_cost_tomselect);

        $search_mfg_over_head_tomselect = \App\Support\UxmalComponents\MfgOverHead\SelectByName::Object();
        $this->BodyInput($search_mfg_over_head_tomselect);

        $this->BodyInput();

        $search_mfg_area_tomselect = \App\Support\UxmalComponents\MfgArea\SelectByName::Object();
        $this->BodyInput($search_mfg_area_tomselect);

        $search_mfg_devices_tomselect = \App\Support\UxmalComponents\MfgDevices\SelectByName::Object();
        $this->BodyInput($search_mfg_devices_tomselect);
    }

}
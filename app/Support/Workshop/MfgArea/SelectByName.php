<?php

namespace App\Support\Workshop\MfgArea;

use App\Models\MfgArea;

class SelectByName extends \App\Support\Workshop\BaseTomSelect
{
    protected string $Model = MfgArea::class;

    protected array $Options = [
        'tomselect.label' => 'Area de manufactura',
        'tomselect.name' => 'mfgAreaSelected',
        'tomselect.placeholder' => 'Seleccionar...',
        'tomselect.load-url' => '/mfg_area/search_tomselect?context=by_name',
        'tomselect.allow-empty-option' => true,
        'tomselect.event-change-handler' => 'onChangeSelectedMfgAreaByName'
    ];

}
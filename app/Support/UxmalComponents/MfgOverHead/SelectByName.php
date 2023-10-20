<?php

namespace App\Support\UxmalComponents\MfgOverHead;

use App\Models\MfgOverhead;

class SelectByName extends \App\Support\UxmalComponents\BaseTomSelect
{
    protected $Model = MfgOverHead::class;

    protected $Options = [
        'tomselect.name' => 'mfgOverHeadSelected',
        'tomselect.placeholder' => 'Costos Indirectos...',
        'tomselect.load-url' => '/mfg_overhead/search_tomselect?context=by_name',
        'tomselect.allow-empty-option' => true,
        'tomselect.event-change-handler' => 'onChangeSelectedMfgOverHeadByName'
    ];
}
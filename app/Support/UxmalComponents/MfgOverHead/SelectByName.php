<?php

namespace App\Support\UxmalComponents\MfgOverHead;

use App\Models\MfgOverhead;

class SelectByName extends \App\Support\UxmalComponents\BaseTomSelect
{
    protected $Model = MfgOverHead::class;

    public function build(): void
    {
        $aggregate = [];

        if (isset($this->attributes['options']['event-change-handler']))
            $aggregate['tomselect.event-change-handler'] = $this->attributes['options']['event-change-handler'];

        $this->Options = [
                'tomselect.label' => 'Costos Indirectos',
                'tomselect.name' => 'mfgOverHeadSelected',
                'tomselect.placeholder' => 'Seleccionar...',
                'tomselect.load-url' => '/mfg_overhead/search_tomselect?context=by_name',
                'tomselect.allow-empty-option' => true
            ] + $aggregate;

        parent::build();
    }
}
<?php

namespace App\Support\Workshop\MfgDevices;

use App\Models\MfgArea;
use App\Models\MfgDevice;
use App\Support\Workshop\BaseTomSelect;

class SelectByName extends BaseTomSelect
{
    protected string $Model = MfgDevice::class;

    protected array $Options = [
        'tomselect.label' => 'Dispositivos',
        'tomselect.name' => 'mfgDevicesSelected',
        'tomselect.placeholder' => 'Seleccionar...',
        'tomselect.load-url' => '/mfg_devices/search_tomselect?context=by_name',
        'tomselect.allow-empty-option' => true,
        'tomselect.event-change-handler' => 'onChangeSelectedMfgDeviceByName'
    ];

    public function searchByMfgArea(string $mfgAreaHashId): array
    {
        $mfg_area_id = MfgArea::keyFromHashId($mfgAreaHashId);
        $rows = MfgDevice::query()
            ->where('mfg_area_id', $mfg_area_id)
            ->select([
                'id',
                'name'
            ])
            ->get();

        $items = [];

        foreach ( $rows as $row ){
            $items[] = [
                'value' => $row->hashId,
                'label' => "{$row->name}"
            ];
        }

        return [
            'incomplete_results' => false,
            'items' => $items
        ];
    }

}
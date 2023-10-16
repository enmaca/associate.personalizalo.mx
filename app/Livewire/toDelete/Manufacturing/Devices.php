<?php

namespace App\Livewire\Manufacturing;

use App\Models\MfgDevice;
use Livewire\Component;

class Devices extends Component
{
    public $mfg_devices;

    public function render()
    {
        $this->mfg_devices = MfgDevice::with(['area'])->get();
        return view('livewire.manufacturing.devices');
    }
}

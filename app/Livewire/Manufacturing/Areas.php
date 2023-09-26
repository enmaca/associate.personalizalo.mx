<?php

namespace App\Livewire\Manufacturing;

use App\Models\MfgArea;
use Livewire\Component;

class Areas extends Component
{
    public $mfg_areas;
    public function render()
    {
        $this->mfg_areas = MfgArea::all()->toArray();
        return view('livewire.manufacturing.areas');
    }
}

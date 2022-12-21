<?php

namespace App\Http\Livewire;

use App\Models\Asset;
use Livewire\Component;

class Chart extends Component
{
    public $pair;

    public function mount($assetId)
    {
        $asset = Asset::find($assetId);
        $this->pair = $asset->base.''.$asset->quote;
    }

    public function render()
    {
        return view('livewire.chart');
    }
}

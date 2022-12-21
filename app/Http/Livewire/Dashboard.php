<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Asset;
use Livewire\Component;
use App\Models\Membership;

class Dashboard extends Component
{
    public $favorite;

    public function mount()
    {
        $assets = Asset::all();
        $max = 0;
        foreach($assets as $asset){
            if($max < $asset->users->count()){
                $max = $asset->users->count();
                $this->favorite = $asset->base.''.$asset->quote;
            }
        }
        if($this->favorite === null){
            $this->favorite = '-';
        }
    }

    public function render()
    {
        return view('livewire.dashboard', [
            'assets'        => Asset::all(),
            'users'         => User::all(),
            'memberships'   => Membership::all(),
        ]);
    }
}

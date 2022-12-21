<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\User;
use App\Models\Asset;
use Illuminate\Support\Facades\Auth;
use App\Notifications\TelegramNotification;

class Profile extends Component
{
    use LivewireAlert;

    public $user;
    public $name;
    public $email;
    public $password;
    public $membership;
    public $assetId;
    public $assets;

    public function submit()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        $this->user->update([
            'name'  => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);
        $this->alert('success', 'Data has been successfully updated');
        $now = date('D M Y - h:m:s');
        if(strpos($user->email, 'group') === FALSE){
            $this->user->notify(new TelegramNotification('Notifikasi Ujicrypto'.PHP_EOL.''.PHP_EOL.'Aktifitas Update Profile pada '.$now));
        }

        $this->password = null;
        $this->emit('pg:eventRefresh-default');
    }

    public function submitAsset(){
        $user = Auth::user();
        $user->assets()->detach();
        $asset = Asset::first();
        for($i=0;$i<$this->user->membership->max_assets;$i++){
            if(isset($this->assetId[$i]) && $this->assetId[$i] !== ''){
                $user->assets()->attach($this->assetId[$i]);
            }
        }
        $this->alert('success', 'Data has been successfully updated');
    }

    public function mount(){
        $user = Auth::user();
        $assets = Asset::all();
        $userAsset = [];
        foreach($user->assets as $asset){
            $userAsset[] = $asset->id;
        }
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->membership = $user->membership;
        $this->assets = $assets;
        $this->assetId = $userAsset;
    }

    public function render()
    {
        return view('livewire.profile');
    }
}

<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Membership;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Memberships extends Component
{
    use LivewireAlert;

    public $membershipId;
    public $level;
    public $max_assets;
    public $showForm = false;

    protected $listeners = ['edit-form' => 'fillForm', 'create-form' => 'createForm'];

    public function fillForm($params)
    {
        $this->resetForm();
        $membership = Membership::find($params['membershipId']);
        $this->membershipId = $membership->id;
        $this->level = $membership->level;
        $this->max_assets = $membership->max_assets;
        $this->showForm = true;
    }

    public function submit()
    {
        $this->validate([
            'level'  => 'required',
            'max_assets' => 'required',
        ]);

        if($this->membershipId)
        {
            $membership = Membership::find($this->membershipId);
            if($membership->exists())
            {
                $membership->update([
                    'level'  => strtoupper($this->level),
                    'max_assets' => $this->max_assets,
                ]);
                $this->alert('success', 'Data has been successfully updated');
            }
        }else{
            Membership::create([
                'level'  => strtoupper($this->level),
                'max_assets' => $this->max_assets,
            ]);
            $this->alert('success', 'Data has been successfully added');
        }
        $this->resetForm();
        $this->emit('pg:eventRefresh-default');
    }

    public function createForm()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function closeForm()
    {
        $this->showForm = false;
    }

    public function resetForm()
    {
        $this->membershipId = null;
        $this->level = null;
        $this->max_assets = null;
    }

    public function render()
    {
        return view('livewire.memberships');
    }
}

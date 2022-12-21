<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Membership;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Users extends Component
{
    use LivewireAlert;

    public $userId;
    public $memberships;
    public $membershipId;
    public $name;
    public $email;
    public $password;
    public $role;
    public $showForm = false;

    protected $listeners = ['edit-form' => 'fillForm', 'create-form' => 'createForm'];

    public function fillForm($params)
    {
        $this->resetForm();
        $user = User::find($params['userId']);
        $this->userId = $user->id;
        $this->membershipId = $user->membership_id ? $user->membership_id : '';
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->password = null;
        $this->showForm = true;
    }

    public function submit()
    {
        if($this->role === 'Admin') $this->membershipId = null;
        if($this->userId)
        {
            $user = User::find($this->userId);
            if($user->exists())
            {
                $this->validate(
                    ['name' => 'required'],
                    ['email' => 'required'],
                    ['role' => 'required']
                );
                if($this->membershipId !== '') $user->membership_id = $this->membershipId;
                $user->name = $this->name;
                $user->email = $this->email;
                if($this->role !== '') $user->role = $this->role;
                if($this->password) $user->password = Hash::make($this->password);
                $user->save();
                $this->alert('success', 'Data has been successfully updated');
            }
        }else{
            if($this->role === 'Member'){
                $this->validate(
                    ['membershipId'  => 'required'],
                    [
                        'membershipId.required' => 'The membership is required.',
                    ],
                    ['name' => 'required'],
                    ['email' => 'required'],
                    ['password' => 'required'],
                    ['role' => 'required'],
                );
            }else{
                $this->validate(
                    ['name' => 'required'],
                    ['email' => 'required'],
                    ['password' => 'required'],
                    ['role' => 'required'],
                );
            }
            User::create([
                'membership_id' => $this->membershipId,
                'name'  => $this->name,
                'email' => $this->email,
                'role'  => $this->role,
                'password' => Hash::make($this->password),
            ]);
            $this->alert('success', 'Data has been successfully added');
        }
        $this->resetForm();
        $this->emit('pg:eventRefresh-default');
    }

    public function updatedRole($role)
    {
        if($role === 'Admin'){
            $this->memberships = array();
        }else{
            $this->memberships = Membership::all();
        }
    }

    public function mount()
    {
        $this->memberships = Membership::all();
        $this->membershipId = '';
        $this->role = '';
        // $this->generateUsers(600);
        // $this->deleteGeneratedUsers();
    }

    public function resetForm()
    {
        $this->userId = null;
        $this->membershipId = '';
        $this->name = null;
        $this->email = null;
        $this->password = null;
        $this->role = '';
    }

    public function createForm()
    {
        $this->showForm = true;
        $this->resetForm();
    }

    public function closeForm()
    {
        $this->resetForm();
        $this->showForm = false;
    }
    
    public function generateUsers($count)
    {
        for($i=0;$i<$count;$i++){
            User::create([
                'membership_id' => 6,
                'name'  => 'Member '.$i,
                'email' => 'emailmember'.str_pad($i, 3, '0', STR_PAD_LEFT).'@gmail.com',
                'role'  => 'Member',
                'password' => Hash::make('passwordmember'.str_pad($i, 3, '0', STR_PAD_LEFT)),
            ]);
        }
    }
    
    public function deleteGeneratedUsers(){
        $users = User::where('role', 'Member')
            ->where('email', 'like', '%emailmember%')->get();
        
        foreach($users as $user){
            $user->delete();
        }
    }

    public function render()
    {
        return view('livewire.users');
    }
}

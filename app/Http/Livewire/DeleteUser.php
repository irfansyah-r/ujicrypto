<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Auth;

class DeleteUser extends ModalComponent
{
    use LivewireAlert;

    public ?int $userId = null;

    public array $userIds = [];

    public string $confirmationTitle = '';

    public string $confirmationDescription = '';

    public static function modalMaxWidth(): string
    {
        return 'md';
    }

    public static function closeModalOnEscape(): bool
    {
        return false;
    }

    public static function closeModalOnClickAway(): bool
    {
        return false;
    }

    public function cancel()
    {
        $this->closeModal();
    }

    public function confirm()
    {
        if(array_search(Auth::user()->id, $this->userIds)){
            $this->alert('error', 'This user can\'t be deleted. Please logout first.');
            $this->closeModal();
            return;
        }
        if ($this->userId) {
            User::query()->find($this->userId)->delete();
        }
        if ($this->userIds) {
            User::query()->whereIn('id', $this->userIds)->delete();
        }

        $this->closeModalWithEvents([
            'pg:eventRefresh-default',
        ]);
        $this->alert('success', 'Data has been successfully deleted');
    }

    public function render()
    {
        return view('livewire.delete-user');
    }
}

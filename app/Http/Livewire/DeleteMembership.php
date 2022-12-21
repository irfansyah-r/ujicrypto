<?php

namespace App\Http\Livewire;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use App\Models\Membership;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class DeleteMembership extends ModalComponent
{
    use LivewireAlert;

    public ?int $membershipId = null;
    public array $membershipIds = [];
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
        if ($this->membershipId) {
            Membership::query()->find($this->membershipId)->delete();
        }

        if ($this->membershipIds) {
            Membership::query()->whereIn('id', $this->membershipIds)->delete();
        }

        $this->closeModalWithEvents([
            'pg:eventRefresh-default',
        ]);
        $this->alert('success', 'Data has been successfully deleted');
    }

    public function render()
    {
        return view('livewire.delete-membership');
    }
}

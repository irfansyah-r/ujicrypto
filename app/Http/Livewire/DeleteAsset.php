<?php

namespace App\Http\Livewire;

use App\Models\Asset;
use LivewireUI\Modal\ModalComponent;
use App\Events\AssetUpdated;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class DeleteAsset extends ModalComponent
{
    use LivewireAlert;

    public ?int $assetId = null;

    public array $assetIds = [];

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
        if ($this->assetId) {
            Asset::query()->find($this->assetId)->delete();
        }
        if ($this->assetIds) {
            Asset::query()->whereIn('id', $this->assetIds)->delete();
        }

        $this->closeModalWithEvents([
            'pg:eventRefresh-default',
        ]);
        $this->alert('success', 'Data has been successfully deleted');
    }
    public function render()
    {
        return view('livewire.delete-asset');
    }
}

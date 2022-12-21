<div class="w-full">
    <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
        <!--- Table --->
        <div class="flex justify-between items-center w-full pb-6">
            <p> Memberships Table</p>
        </div>
        <div class="overflow-hidden">
            <livewire:membership-table/>
        </div>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-lg mb-8 transform transition-all duration-150 ease-in-out {{$showForm ? 'scale-100':'scale-0'}}">
        <!-- Form -->
        <div class="flex justify-between items-center w-full pb-6">
            <p> {{ $membershipId ? 'Edit':'Create New' }} Membership</p>
            <div>
                <button wire:click="closeForm" class="items-center p-0 justify-center p-2 text-black hover:text-red-500 outline outline-2 rounded-sm transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        <div class="overflow-hidden" >
            <form wire:submit.prevent="submit">
                <div>
                    <div class="grid md:grid-cols-3 gap-4">
                        <x-input type="hidden" wire:model="membershipId" value="{{$membershipId}}"></x-input>
                        <div>
                            <x-label>Level*</x-label>
                            <x-input class="w-full" type="text" wire:model="level" id="level" style="text-transform: uppercase;" autoComplete='none' ></x-input>
                            @error('level') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <x-label>Max Assets*</x-label>
                            <x-input class="w-full" type="text" wire:model="max_assets" id="max_assets" style="text-transform: uppercase;" autoComplete='none' ></x-input>
                            @error('max_assets') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <x-button type="submit" class="mt-6">Save</x-button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

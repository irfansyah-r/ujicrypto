<div class="w-full">
    <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
        <!--- Table --->
        <div class="flex justify-between items-center w-full pb-6">
            <p> Users Table</p>
        </div>
        <div class="overflow-hidden">
            <livewire:user-table/>
        </div>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-lg mb-8 transform transition-all duration-150 ease-in-out {{$showForm ? 'scale-100':'scale-0'}}">
        <!-- Form -->
        <div class="flex justify-between items-center w-full pb-6">
            <p> {{ $userId ? 'Edit':'Create new'}} User</p>
            <div>
                <button wire:click="closeForm" class="items-center p-0 justify-center p-2 text-black hover:text-red-500 outline outline-2 rounded-sm transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        <div class="overflow-hidden">
            <form wire:submit.prevent="submit">
                <div>
                    @error('pair') <span class="error text-red-500">{{ $message }}</span><br/> @enderror
                    <div class="grid md:grid-cols-3 gap-4">
                        <x-input type="hidden" wire:model="userId" value="{{$userId}}"></x-input>
                        <div>
                            <x-label>Membership*</x-label>
                            <select wire:model="membershipId" {{$role === 'Admin' ? 'disabled':''}} id="membershipId" class="{{$role === 'Admin' ? 'bg-gray-200':'bg-white'}} border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="" disabled>Choose Membership</option>
                                @foreach ($memberships as $membership)
                                    <option value="{{$membership->id}}">{{$membership->level}}</option>
                                @endforeach
                            </select>
                            @error('membershipId') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <x-label>Name*</x-label>
                            <x-input class="w-full" type="text" wire:model="name" id="name" autoComplete='none' ></x-input>
                            @error('name') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <x-label>Email*</x-label>
                            <x-input class="w-full" type="email" wire:model="email" id="email" autoComplete='none' ></x-input>
                            @error('email') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <x-label>Password*</x-label>
                            <x-input class="w-full" type="password" wire:model="password" id="password" autoComplete='none' ></x-input>
                            @error('password') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <x-label>Role*</x-label>
                            <select wire:model="role" id="role" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="" disabled>Choose Role</option>
                                <option value="Member">Member</option>
                                <option value="Admin">Admin</option>
                            </select>
                            @error('role') <span class="error">{{ $message }}</span> @enderror
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

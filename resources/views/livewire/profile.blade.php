<div class="w-full">
    <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
        Profile User
        <hr class="my-5">
        <div class="w-full">
            <form wire:submit.prevent="submit">
                <div>
                    <div class="grid md:grid-cols-2 gap-4 md:mx-28">
                        <div class="md:pt-4">
                            <x-label>Membership Level</x-label>
                        </div>
                        <div class="md:pt-4">
                            {{$membership ? $membership->level : 'No membership'}}
                        </div>
                        @if(auth()->user()->membership_id)
                            <div class="md:pt-4">
                                <x-label>Connect to telegram</x-label>
                            </div>
                            <div>
                                @if(auth()->user()->telegram_chat_id)
                                    <div class="pt-2">Telegram Connected</div>
                                @else
                                    <script
                                        async
                                        type="application/javascript"
                                        src="https://telegram.org/js/telegram-widget.js?7"
                                        data-telegram-login="{{ config('services.telegram-bot-api.name') }}"
                                        data-size="large"
                                        data-auth-url="{{ route('telegram.connect') }}"
                                        data-request-access="write"
                                    ></script>
                                @endif
                            </div>
                        @endif
                        <div class="md:pt-4">
                            <x-label>Name*</x-label>
                        </div>
                        <div>
                            <x-input class="w-full" type="text" wire:model="name" id="name" autoComplete='none' ></x-input>
                            @error('name') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="md:pt-4">
                            <x-label>Email*</x-label>
                        </div>
                        <div>
                            <x-input class="w-full" type="email" wire:model="email" id="email" autoComplete='none' ></x-input>
                            @error('email') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="md:pt-4">
                            <x-label>Password*</x-label>
                        </div>
                        <div>
                            <x-input class="w-full" type="password" wire:model="password" id="password" autoComplete='none' ></x-input>
                            @error('password') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <x-button type="submit" class="mt-6">Save</x-button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @if ($membership !== null && $membership->max_assets > 0)
        <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
            User Asset
            <hr class="my-5">
            <form method="post" wire:submit.prevent="submitAsset">
                @csrf
                <div class="grid md:grid-cols-2 gap-4 md:mx-28">
                    @for ($i=0;$i<$membership->max_assets;$i++)
                        <div class="pt-4">
                            <x-label>Select Asset {{$i+1}} for notification</x-label>
                        </div>
                        <div>
                            <select wire:model="assetId.{{$i}}" id="assetId.{{$i}}" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">-- Select asset --</option>
                                @foreach ($assets as $asset)
                                    <option value="{{$asset->id}}">{{$asset->base.''.$asset->quote}}</option>
                                @endforeach
                            </select>
                        </div>
                    @endfor
                    <div>
                        <x-button type="submit" class="mt-6">Save</x-button>
                    </div>
                </div>
            </form>
        </div>
    @endif
</div>

<div class="w-full">
    <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
        <!--- Table --->
        <div class="flex justify-between items-center w-full pb-6">
            <p> Assets Table</p>
        </div>
        <div class="overflow-hidden">
            <livewire:asset-table/>
        </div>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-lg mb-8 transform transition-all duration-150 ease-in-out {{$showForm ? 'scale-100':'scale-0'}}">
        <!-- Form -->
        <div class="flex justify-between items-center w-full pb-6">
            <p> {{ $assetId ? 'Edit':'Create New' }} Asset</p>
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
                        <x-input type="hidden" wire:model="assetId" value="{{$assetId}}"></x-input>
                        <div>
                            <x-label>Base*</x-label>
                            <x-input class="w-full" type="text" wire:model="base" id="base" style="text-transform: uppercase;" autoComplete='none' ></x-input>
                            @error('base') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <x-label>Quote*</x-label>
                            <x-input class="w-full" type="text" wire:model="quote" id="quote" style="text-transform: uppercase;" autoComplete='none' ></x-input>
                            @error('quote') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <x-button type="submit" class="mt-6">Save</x-button>
                        </div>
                    </div>
                </div>
            </form>
            <script type="text/javascript">
                // CSRF Token
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $(document).ready(function(){
                    let asset = @this.pair;
                    $('#base').autocomplete({
                        source: asset.base,
                    });
                    $('#quote').autocomplete({
                        source: asset.quote,
                    });
                });
                // $.ajax({
                //     url: "../../api/binance/market",
                //     type: "GET",
                //     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                //     async: true,
                //     success: function(asset){
                //         $('#base').autocomplete({
                //             source: asset.base,
                //         });
                //         $('#quote').autocomplete({
                //             source: asset.quote,
                //         });
                //     },
                // })
            </script>
        </div>
    </div>
</div>

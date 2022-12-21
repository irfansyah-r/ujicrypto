<div class="bg-white p-6 rounded-lg shadow-lg mb-8">
    <!--- Monitoring --->
    <div class="flex justify-between items-center w-full pb-6">
        <p> {{ $pair }} Price Chart</p>
        <x-input type="hidden" id="pair" value="{{$pair}}" ></x-input>
    </div>
    <div class="flex overflow-hidden">
        {{-- Success is as dangerous as failure. --}}
        <div id="container" style="width: 100%;height: 610px;overflow-x:auto;" class="overflow-y-hidden justify-content-center items-center flex flex-col">
            <div id="chartdiv" class="overflow-hidden w-full" style="height: 605px;">
                <div class="overflow-y-hidden" style="background-color: white;width: 100%;height: 100%;display: flex;align-items: center;justify-content: center;">
                    <!--<p style="font-size: 36px;">Loading.....</p>-->
                    <div class="spinner-border" style="width: 5rem; height: 5rem;" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('js/candleChart.js') }}"></script>
    </div>
</div>

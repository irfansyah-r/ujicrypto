<div class="w-full">
    <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
        <!--- Table --->
        <div class="flex justify-between items-center w-full pb-6">
            <p> Indication Table</p>
        </div>
        <div class="overflow-hidden">
            <livewire:indication-table />
        </div>
    </div>
    <script>
        let counter = 0;
        paintTable();
        setInterval(function (){
            if(counter > 5){
                Livewire.emit('pg:eventRefresh-default');
                counter = 0;
            }else{
                counter++;
            }
            paintTable();
        }, 1000);
    
        function paintTable(){
            const table = document.getElementsByTagName("table");
            const trs = table[0].children[1].children;
            for(var i=1; i<trs.length; i++){
                var tr = trs[i];
                var ma = tr.children[3];
                var psar = tr.children[5];
                var stochastic = tr.children[7];
                if(ma.children[0].children[0].innerHTML.indexOf("No") !== -1){
                    tr.children[2].classList.add('text-red-500')
                    ma.classList.add('text-red-500');
                }else{
                    tr.children[2].classList.add('text-green-500')
                    ma.classList.add('text-green-500');
                }
                if(psar.children[0].children[0].innerHTML.indexOf("No") !== -1){
                    tr.children[4].classList.add('text-red-500')
                    psar.classList.add('text-red-500');
                }else{
                    tr.children[4].classList.add('text-green-500')
                    psar.classList.add('text-green-500');
                }
                if(tr.children[6].children[0].children[0].innerHTML.indexOf("Sideways") !== -1 || stochastic.children[0].children[0].innerHTML.indexOf("No") !== -1){
                    if(tr.children[6].children[0].children[0].innerHTML.indexOf("Sideways") !== -1){
                        tr.children[6].classList.add('text-red-500');
                    }else{
                        tr.children[6].classList.add('text-green-500');
                    }
                    stochastic.classList.add('text-red-500');
                }else{
                    tr.children[6].classList.add('text-green-500');
                    stochastic.classList.add('text-green-500');
                }
            }
        }
    </script>
</div>

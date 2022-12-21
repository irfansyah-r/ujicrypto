<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Asset;
use Illuminate\Support\Facades\Http;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Assets extends Component
{
    use LivewireAlert;

    public $assetId;
    public $base;
    public $quote;
    public $pair;
    public $showForm = false;

    protected $listeners = ['edit-form' => 'fillForm', 'create-form' => 'createForm'];

    public function fillForm($params)
    {
        $asset = Asset::find($params['assetId']);
        $this->assetId = $asset->id;
        $this->base = $asset->base;
        $this->quote = $asset->quote;
        $this->showForm = true;
    }

    public function submit()
    {
        $this->validate([
            'base'  => 'required',
            'quote' => 'required'
        ]);
        $existingAsset = Asset::where('base', $this->base)
                            ->where('quote', $this->quote);
        if(!$existingAsset->exists()){
            $pair = strtoupper($this->base.''.$this->quote);
            if(!in_array($pair, $this->pair['symbol'])){
                $this->addError('pair', 'Pair Asset doesn\'t match with Binance API');
                return null;
            }
            if($this->assetId)
            {
                $asset = Asset::find($this->assetId);
                if($asset->exists())
                {
                    $asset->update([
                        'base'  => strtoupper($this->base),
                        'quote' => strtoupper($this->quote),
                    ]);
                }
                $this->alert('success', 'Data has been successfully updated');
            }else{
                Asset::create([
                    'base'  => strtoupper($this->base),
                    'quote' => strtoupper($this->quote),
                ]);
                $this->alert('success', 'Data has been successfully added');
            }
        }else{
            $this->addError('pair', 'Pair Asset already set in database');
            return null;
        }
        $this->resetForm();
        $this->emit('pg:eventRefresh-default');
    }

    public function mount()
    {
        $this->pair = $this->getAsset();
        // foreach($this->pair['symbols'] as $symbol){
        //     $asset = Asset::where('base', $symbol['baseAsset'])
        //         ->where('quote', $symbol['quoteAsset']);
        //     if(!$asset->exists() && ($symbol['quoteAsset'] === 'USDT')){
        //         Asset::create([
        //             'base'  => strtoupper($symbol['baseAsset']),
        //             'quote' => strtoupper($symbol['quoteAsset']),
        //         ]);
        //         return;
        //     }
        // }
    }

    public function createForm()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function closeForm()
    {
        $this->showForm = false;
    }

    public function resetForm()
    {
        $this->assetId = null;
        $this->base = null;
        $this->quote = null;
    }

    public function render()
    {
        return view('livewire.assets');
    }

    public function getAsset()
    {
        $response = Http::get('https://api.binance.com/api/v1/exchangeInfo');
        if($response->successful()){
            $response = $response->json();
            // $symbols = $response['symbols'];
            $symbol = array_unique(array_column($response['symbols'], "symbol"));
            $base = array_unique(array_column($response['symbols'], "baseAsset"));
            $quote = array_unique(array_column($response['symbols'], "quoteAsset"));
            $baseArray = array();$quoteArray = array();
            foreach ($base as $value) {
                $baseArray[] = array(
                    'label' => $value,
                    'value'=> $value,
                );
            }
            foreach ($quote as $value) {
                $quoteArray[] = array(
                    'label' => $value,
                    'value'=> $value,
                );
            }
            $data = array(
                'base'      => $baseArray,
                'quote'     => $quoteArray,
                'symbol'    => $symbol,
                // 'symbols'   => $symbols,
            );
            return $data;
        }
    }
}

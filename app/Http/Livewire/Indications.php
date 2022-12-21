<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Indication;
use App\Models\Asset;
use Illuminate\Support\Facades\Http;

class Indications extends Component
{
    public $page;
    public $asset;
    public $pair;
    protected $listeners = ['get-chartdata' => 'getChartData', 'get-back' => 'getBack'];

    public function getChartData($assetId)
    {
        $this->asset = Asset::find($assetId)->firstOrFail();
        $this->pair = $this->asset->base.''.$this->asset->quote;
        $this->page = 'chart';
    }

    public function getBack()
    {
        $this->page = 'table';
    }

    public function mount()
    {
        $indications = Indication::all();
        $this->page = 'table';
        // $this->getData();
    }

    public function render()
    {
        return view('livewire.indications');
    }



    public function getData(){
        $assets = Asset::all();
        foreach($assets as $asset){
            $pair = strtoupper($asset->base.''.$asset->quote);
            $data = $this->prosesData($pair);
            $indication = Indication::where('asset_id', $asset->id);
            if(!$indication->exists()){
                Indication::create([
                    'asset_id'              => $asset->id,
                    'ma_trend'              => $data['ma_trend'],
                    'ma_crossover'          => $data['ma_crossover'],
                    'psar_trend'            => $data['psar_trend'],
                    'psar_reversal'         => $data['psar_reversal'],
                    'stochastic_trend'      => $data['stochastic_trend'],
                    'stochastic_crossover'  => $data['stochastic_crossover'],
                ]);
            }else{
                $indication->update([
                    'ma_trend'              => $data['ma_trend'],
                    'ma_crossover'          => $data['ma_crossover'],
                    'psar_trend'            => $data['psar_trend'],
                    'psar_reversal'         => $data['psar_reversal'],
                    'stochastic_trend'      => $data['stochastic_trend'],
                    'stochastic_crossover'  => $data['stochastic_crossover'],
                ]);
            }
            dd($data);
            $list = $data['list'];
            $msg = 'Ujicrypto Notification'.PHP_EOL.''.PHP_EOL.'Asset : '.$asset->base.''.$asset->quote;
            if($data['ma_crossover']){
                $msg .= PHP_EOL.'- CrossOver now on Moving Average';
            }
            if($data['psar_reversal']){
                $msg .= PHP_EOL.'- Reversal now on Parabolic SAR';
            }
            if($data['stochastic_crossover']){
                $msg .= PHP_EOL.'- CrossOver now on Stochastic';
            }
            $msg .= PHP_EOL.''.PHP_EOL.'On Price : '.$list[count($list)-1][4];
            foreach($asset->users as $user){
                $user->notify(new TelegramNotification($msg));
            }
        }
    }

    public function prosesData($asset)
    {
        $data = Http::get('https://api.binance.com/api/v1/klines?symbol='.$asset.'&interval=30m&limit=250')->json();

        $periodeMA = 50;
        $periodeEMA = 5;
        $ma_crossover = '';$ma_trend = '';

        $periodeK = 14;
        $periodeD = 3;

        $persenK = [];
        $persenD = [];
        $ma = [];
        $ema = [];
        $parabolicSAR = [];

        $closeIndex = 4;
        $highIndex = 2;
        $lowIndex = 3;

        //PSAR
        $Acc = 0.02;
        $EP = ($data[0][$lowIndex]);
        $hp = ($data[0][$highIndex]);
        $lp = ($data[0][$lowIndex]);
        $up = true;
        $PSar = 0;

        $list = array_slice($data, $periodeMA, count($data));
        for ($i=0; $i < count($list); $i++) {
            $sum = 0;
            for($j=$i; $j < ($i+$periodeMA); $j++){
                $sum = $sum+(($data[$j][$closeIndex]));
            }
            $sum = $sum/50;
            $ma[] = $sum;

            $close = ($list[$i][$closeIndex]);
            if($i == 0){
                $jml = (($close-$sum)*(2/$periodeEMA))+$sum;
            }else{
                $jml = (($close-$jml)*(2/$periodeEMA))+$jml;
            }
            $ema[] = $jml;

            if($i>1){
                if($ma[count($ma)-1] < $ema[count($ema)-1]){
                    $ma_trend = "Uptrend";
                    if($ma[count($ma)-2] > $ema[count($ema)-2]){
                        $ma_crossover = true;
                    }else{
                        $ma_crossover = false;
                    }
                }else{
                    $ma_trend = "Downtrend";
                    if($ma[count($ma)-2] < $ema[count($ema)-2]){
                        $ma_crossover = true;
                    }else{
                        $ma_crossover = false;
                    }
                }
            }

            //Stochastic Oscilator
            // if($i > 0){
                $highest = $data[$i+($periodeMA-$periodeK)][$lowIndex];
                $lowest = $data[$i+($periodeMA-$periodeK)][$highIndex];
                for($j = ($i+($periodeMA-$periodeK));$j <= ($i+$periodeMA); $j++){
                    if($data[$j][$lowIndex] < $lowest){
                        $lowest = $data[$j][$lowIndex];
                    }
                    if($data[$j][$highIndex] > $highest){
                        $highest = $data[$j][$highIndex];
                    }
                }
                $persenK[] = (100*(($close-$lowest)/($highest-$lowest)));
                if($i >= 2){
                    $sum = 0;
                    for($j=$i-2;$j <= $i; $j++){
                        $sum += $persenK[$j];
                    }
                    $persenD[] = $sum/3;
                }else{
                    $persenD[] = $persenK[$i];
                }
            // }else{
            //     $persenD[] = 0;
            //     $persenK[] = 0;
            // }
            if($i > 0){
                if($persenK[$i] <= 20 && $persenD[$i] <= 20){
                    $stochastic_trend = "Oversold";
                    if($persenK[$i] > $persenD[$i] && $persenK[$i-1] < $persenD[$i-1]){
                        $stochastic_crossover = true;
                    }else{
                        $stochastic_crossover = false;
                    }
                }elseif($persenK[$i] >= 80 && $persenD[$i] >= 80){
                    $stochastic_trend = "Overbought";
                    if($persenK[$i] < $persenD[$i] && $persenK[$i-1] > $persenD[$i-1]){
                        $stochastic_crossover = true;
                    }else{
                        $stochastic_crossover = false;
                    }
                }else{
                    $stochastic_trend = "Sideways";
                    if(($persenK[$i] > $persenD[$i] && $persenK[$i-1] < $persenD[$i-1]) || ($persenK[$i] < $persenD[$i] && $persenK[$i-1] > $persenD[$i-1])){
                        $stochastic_crossover = true;
                    }else{
                        $stochastic_crossover = false;
                    }
                }
            }

            //Hitunf PSAR
            if ($i > 0) {
                $SARn = $PSar;
                if ($up) {
                    $PSar = $SARn + $Acc * ($hp - $SARn);
                } else {
                    $PSar = $SARn + $Acc * ($lp - $SARn);
                }
                $reverse = false;
                if ($up) {
                    if ($list[$i][$lowIndex] < $PSar) {
                        $up = false;
                        $reverse = true;
                        $PSar = $hp;
                        $lp = ($list[$i][$lowIndex]);
                        $Acc = 0.02;
                    }
                } else {
                    if ($list[$i][$highIndex] > $PSar) {
                        $up = true;
                        $reverse = true;
                        $PSar = $lp;
                        $hp = ($list[$i][$highIndex]);
                        $Acc = 0.02;
                    }
                }
                if (!$reverse && $i > 1) {
                    if ($up) {
                        if ($list[$i][$highIndex] > $hp) {
                            $hp = ($list[$i][$highIndex]);
                            $Acc = min($Acc + 0.02, 0.2);
                        }
                        if ($list[$i - 1][$lowIndex] < $PSar) {
                            $PSar = ($list[$i - 1][$lowIndex]);
                        }
                        if ($list[$i - 2][$lowIndex] < $PSar) {
                            $PSar = ($list[$i - 2][$lowIndex]);
                        }
                    } else {
                        if ($list[$i][$lowIndex] < $lp) {
                            $lp = $list[$i][$lowIndex];
                            $Acc = min($Acc + 0.02, 0.2);
                        }
                        if ($list[$i - 1][$highIndex] > $PSar) {
                            $PSar = ($list[$i - 1][$highIndex]);
                        }
                        if ($list[$i - 2][$highIndex] > $PSar) {
                            $PSar = ($list[$i - 2][$highIndex]);
                        }
                    }
                }
            } else {
                $PSar = $list[$i][$closeIndex];
            }
            $PSar = ($PSar);
            $parabolicSAR[] = (float)$PSar;


            if($i>0){
                $close = ($list[$i][$closeIndex]);
                $prevClose = ($list[$i-1][$closeIndex]);
                if($parabolicSAR[$i] < $close){
                    $psar_trend = "Uptrend";
                    if($parabolicSAR[$i-1] > $prevClose){
                        $psar_reversal = true;
                    }else{
                        $psar_reversal = false;
                    }
                }else{
                    $psar_trend = "Uptrend";
                    if($parabolicSAR[$i-1] < $prevClose){
                        $psar_reversal = true;
                    }else{
                        $psar_reversal = false;
                    }
                }
            }

        }
        dd($persenK, $asset);
        $result = [
            'ma_trend'              => $ma_trend,
            'ma_crossover'          => $ma_crossover,
            'stochastic_trend'      => $stochastic_trend,
            'stochastic_crossover'  => $stochastic_crossover,
            'psar_trend'            => $psar_trend,
            'psar_reversal'         => $psar_reversal,
            'list'                  => $list,
        ];

        return $result;
    }
}

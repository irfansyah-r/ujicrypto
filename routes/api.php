<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('binance/kline/{asset}', function($asset){
    $url = 'https://api.binance.com/api/v1/klines?symbol='.$asset.'&interval=1h';
    $data = Http::get($url)->json();
    return $data;
});

Route::get('binance/market', function() {
    $response = Http::get('https://api.binance.com/api/v1/exchangeInfo')->json();
    $symbols = array_unique(array_column($response['symbols'], "symbol"));
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
        'symbols'    => $symbols,
    );
    return $data;
});

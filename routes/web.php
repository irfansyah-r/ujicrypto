<?php

use App\Http\Livewire\Chart;
use App\Http\Livewire\Users;
use App\Http\Livewire\Assets;
use App\Http\Livewire\Profile;
use App\Http\Livewire\Indications;
use App\Http\Livewire\Memberships;
use App\Http\Livewire\Dashboard;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TelegramController;
use App\Http\Controllers\IndicationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('landing');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard')->withoutMiddleware(['admin']);
    Route::get('/profile', Profile::class)->name('profile')->withoutMiddleware(['admin']);
    Route::get('/indications', Indications::class)->name('indications')->withoutMiddleware(['admin']);
    Route::get('/memberships', Memberships::class)->name('memberships');
    Route::get('/users', Users::class)->name('users');
    Route::get('/assets', Assets::class)->name('assets');
    Route::get('/indication/chart/{assetId}', Chart::class)->name('indication.chart')->withoutMiddleware(['admin']);
    Route::get('/telegram', [TelegramController::class, 'callback'])->name('telegram.connect')->withoutMiddleware(['admin']);
});


require __DIR__.'/auth.php';

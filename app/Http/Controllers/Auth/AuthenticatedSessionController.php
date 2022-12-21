<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\TelegramNotification;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();
        $user = User::find(Auth::user()->id);
        $now = date('D M Y - h:m:s');

        if($user->role === 'Member' && isset($user->telegram_chat_id) && strpos($user->email, 'group') === FALSE){
            $user->notify(new TelegramNotification('Notifikasi Ujicrypto'.PHP_EOL.''.PHP_EOL.'Aktifitas Login pada '.$now));
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $now = date('D M Y - h:m:s');

        if($user->role === 'Member' && isset($user->telegram_chat_id) && strpos($user->email, 'group') === FALSE){
            $user->notify(new TelegramNotification('Notifikasi Ujicrypto'.PHP_EOL.''.PHP_EOL.'Aktifitas Logout pada '.$now));
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

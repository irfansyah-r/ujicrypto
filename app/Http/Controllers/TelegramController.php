<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use pschocke\TelegramLoginWidget\Facades\TelegramLoginWidget;

class TelegramController extends Controller
{
    public function callback(Request $request){
        if (! $telegramUser = TelegramLoginWidget::validate($request)) {
            return 'Telegram Response not valid';
        }
        $telegramChatID = $telegramUser->get('id');
        auth()->user()->update([
            'telegram_chat_id' => $telegramChatID
        ]);
        // You need to store the chat ID to be able to use it later
        // return 'Success!';
        return redirect()->route('profile');
    }

    public function sendMessage()
    {

    }
}

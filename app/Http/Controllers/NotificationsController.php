<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $messages = Message::query()->where('to_user_id', $user->id)->get();
        $messagesCount = Message::query()->where('to_user_id', $user->id)
            ->where('has_read', 'F')->count();
        return view('notifications.messages', compact('user', 'messages', 'messagesCount'));
    }

    public function notifications()
    {
        $user = Auth::user();
        $messages = Message::query()->where('to_user_id', $user->id)->get();
        $messagesCount = Message::query()->where('to_user_id', $user->id)
            ->where('read_at', null)->count();
        return view('notifications.notifications', compact('user', 'messages', 'messagesCount'));

    }
}

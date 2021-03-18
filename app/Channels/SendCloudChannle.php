<?php


namespace App\Channels;
use Illuminate\Notifications\Notification;
class SendCloudChannle
{

    public function send($notifiable,Notification $notification)
    {
        $message = $notification->toSendCloud($notifiable);
    }
}

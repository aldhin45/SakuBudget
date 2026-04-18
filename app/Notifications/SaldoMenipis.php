<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class SaldoMenipis extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['database']; // simpan ke database
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Saldo Menipis',
            'message' => 'Saldo kamu hampir habis, segera lakukan top up!',
        ];
    }
}
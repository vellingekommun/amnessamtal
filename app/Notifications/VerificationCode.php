<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

use NotificationChannels\FortySixElks\FortySixElksChannel;
use NotificationChannels\FortySixElks\FortySixElksSMS;

class VerificationCode extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        return [FortySixElksChannel::class];
    }

    public function to46Elks($notifiable)
    {
        return (new FortySixElksSMS())
            ->line($notifiable->verification_code)
            ->to($notifiable->phone)
            ->from('Sunds');
    }
}
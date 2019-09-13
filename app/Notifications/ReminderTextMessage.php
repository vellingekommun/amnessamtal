<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

use NotificationChannels\FortySixElks\FortySixElksChannel;
use NotificationChannels\FortySixElks\FortySixElksSMS;

class ReminderTextMessage extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        return [FortySixElksChannel::class];
    }

    public function to46Elks($notifiable)
    {
        return (new FortySixElksSMS())
                ->line(str_replace("{länk}" , route('view', $notifiable->token), str_replace ("{datum}" , $notifiable->event->starts_at->format('Y-m-d'), $notifiable->event->sms_reminder)))
                ->to($notifiable->phone)
                ->from('Sunds');
    }
}
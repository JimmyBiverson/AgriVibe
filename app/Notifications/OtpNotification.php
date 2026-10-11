<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OtpNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public string $code, public string $purpose = 'login')
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your '.config('agrivibe.app_name', 'Agrivibe').' verification code')
            ->greeting('Hello '.($notifiable->name ?? 'there').',')
            ->line('Use the code below to complete your '.$this->purpose.'. It expires in 10 minutes.')
            ->line('**'.$this->code.'**')
            ->line('If you did not request this code, you can safely ignore this email.');
    }
}
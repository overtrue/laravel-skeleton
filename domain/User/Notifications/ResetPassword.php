<?php

namespace Domain\User\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification
{
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage())
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->action('Reset Password', url(config('app.url').'/password/reset/'.$this->token).'?email='.urlencode($notifiable->email))
            ->line('If you did not request a password reset, no further action is required.');
    }
}

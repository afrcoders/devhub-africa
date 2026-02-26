<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordResetNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $resetUrl,
        public User $user
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Reset Your Password')
            ->greeting('Hello ' . $this->user->full_name . '!')
            ->line('You requested a password reset for your Africoders ID account.')
            ->action('Reset Password', $this->resetUrl)
            ->line('This password reset link will expire in 1 hour.')
            ->line('If you did not request this password reset, please ignore this email.')
            ->salutation('Best regards, Africoders Team');
    }
}

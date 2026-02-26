<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\EmailVerificationToken;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailVerificationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public EmailVerificationToken $verificationToken,
        public User $user
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $verificationUrl = route('id.verify-email-token', ['token' => $this->verificationToken->token]);

        return (new MailMessage)
            ->subject('Verify Your Email Address')
            ->greeting('Hello ' . $this->user->full_name . '!')
            ->line('Thank you for signing up. Please verify your email address to complete your registration.')
            ->action('Verify Email', $verificationUrl)
            ->line('This verification link will expire in 24 hours.')
            ->line('If you did not create this account, please disregard this email.')
            ->salutation('Best regards, Africoders Team');
    }
}

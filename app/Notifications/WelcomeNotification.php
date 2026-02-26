<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public User $user
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Welcome to Africoders ID')
            ->greeting('Welcome, ' . $this->user->full_name . '!')
            ->line('Thank you for joining the Africoders community. Your account has been created successfully.')
            ->line('To get started, please verify your email address by clicking the verification link in your inbox.')
            ->line('Once verified, you\'ll have full access to:')
            ->line('• Connect with talented developers across Africa')
            ->line('• Showcase your skills and experience')
            ->line('• Discover learning opportunities')
            ->line('• Network with tech entrepreneurs')
            ->action('Verify Email', route('verify-email.show'))
            ->line('Questions? Check out our help center at ' . config('domains.africoders.help') . '')
            ->closing('Welcome aboard!')
            ->salutation('Africoders Team');
    }
}

<?php

namespace App\Listeners;

use App\Events\EmailVerificationTokenCreated;
use App\Notifications\EmailVerificationNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailVerificationNotification implements ShouldQueue
{
    public function handle(EmailVerificationTokenCreated $event): void
    {
        $user = $event->token->user;
        $user->notify(new EmailVerificationNotification($event->token, $user));
    }
}

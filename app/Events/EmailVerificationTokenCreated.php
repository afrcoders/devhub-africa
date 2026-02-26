<?php

namespace App\Events;

use App\Models\EmailVerificationToken;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EmailVerificationTokenCreated
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public EmailVerificationToken $token
    ) {}
}

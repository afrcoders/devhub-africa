<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NotDisposableEmail implements ValidationRule
{
    /**
     * List of common disposable email domains
     */
    private array $disposableDomains = [
        // Russian disposable domains
        'yandex.ru',
        'yandex.com',
        'yandex.ua',
        'mail.ru',
        'bk.ru',
        'inbox.ru',
        'list.ru',

        // Popular disposable email services
        '10minutemail.com',
        'tempmail.com',
        'throwaway.email',
        'guerrillamail.com',
        'mailinator.com',
        'temp-mail.org',
        'fakeinbox.com',
        'maildrop.cc',
        'trashmail.com',
        'spam4.me',
        'mytrashmail.com',
        'sharklasers.com',
        'temp-mail.io',
        'guerrillamail.info',
        'grr.la',
        'pokemail.net',
        'yopmail.com',

        // Other suspicious domains
        'test.com',
        'test.org',
        'example.com',
        'domain.com',
        'temp-email.net',
    ];

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Extract domain from email
        $emailDomain = strtolower(substr(strrchr($value, '@'), 1));

        // Check if domain is in disposable list
        if (in_array($emailDomain, $this->disposableDomains)) {
            $fail("The {$attribute} address uses a disposable email service. Please use a permanent email address.");
        }
    }
}

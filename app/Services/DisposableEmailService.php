<?php

namespace App\Services;

class DisposableEmailService
{
    /**
     * List of common disposable email domains
     */
    private array $disposableDomains = [
        // Russian disposable domains
        'yandex.ru',
        'yandex.com',
        'yandex.ua',
        'yandex.by',
        'mail.ru',
        'bk.ru',
        'inbox.ru',
        'list.ru',
        'corp.mail.ru',

        // Popular disposable email services
        '10minutemail.com',
        '10minutemail.net',
        'tempmail.com',
        'tempmail.org',
        'throwaway.email',
        'guerrillamail.com',
        'guerrillamail.info',
        'guerrillamail.net',
        'grr.la',
        'mailinator.com',
        'mailinator.net',
        'temp-mail.org',
        'temp-mail.io',
        'fakeinbox.com',
        'maildrop.cc',
        'trashmail.com',
        'trash-mail.com',
        'spam4.me',
        'mytrashmail.com',
        'sharklasers.com',
        'pokemail.net',
        'yopmail.com',
        'yopmail.net',
        'yopmail.fr',
        'temp-mail.top',
        'emailnesia.com',
        'anonbox.net',
        'maildrop.cc',
        'temp-email.net',
        'tempmail.ninja',
        'trashmail.ws',
        'safersignup.de',
        'minutemail.net',
        'temp-mail.cloud',
        'testmail.best',
        'mailnesia.com',
        'maildrop.cc',
        'temp-email.org',

        // Other suspicious domains
        'test.com',
        'test.org',
        'test.net',
        'example.com',
        'example.org',
        'example.net',
        'domain.com',
        'localhost',
        'localhost.com',
    ];

    /**
     * Check if an email address is using a disposable domain
     *
     * @param string $email
     * @return bool
     */
    public function isDisposable(string $email): bool
    {
        // Extract domain from email
        $emailDomain = strtolower(substr(strrchr($email, '@'), 1));

        // Check if domain is in disposable list
        return in_array($emailDomain, $this->disposableDomains, true);
    }

    /**
     * Get all disposable domains
     *
     * @return array
     */
    public function getDisposableDomains(): array
    {
        return $this->disposableDomains;
    }

    /**
     * Add a custom disposable domain
     *
     * @param string $domain
     * @return void
     */
    public function addDisposableDomain(string $domain): void
    {
        $domain = strtolower($domain);
        if (!in_array($domain, $this->disposableDomains)) {
            $this->disposableDomains[] = $domain;
        }
    }

    /**
     * Remove a domain from disposable list
     *
     * @param string $domain
     * @return void
     */
    public function removeDisposableDomain(string $domain): void
    {
        $domain = strtolower($domain);
        $key = array_search($domain, $this->disposableDomains, true);
        if ($key !== false) {
            unset($this->disposableDomains[$key]);
        }
    }
}

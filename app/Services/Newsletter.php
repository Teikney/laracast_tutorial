<?php

namespace App\Services;
use MailchimpMarketing\ApiClient;

class Newsletter
{

    public function __construct(ApiClient $client)
    {

    }

    public function subscribe(string $email, string $list = null)
    {
        // '??=' is the null safe assignment operator(maybe)
        $list ??= config('services.mailchimp.lists.subscribers');

        return $this->client->lists->addListMember($list, [
            'email_address' => $email,
            'status' => 'subscribed'
        ]);
    }
}



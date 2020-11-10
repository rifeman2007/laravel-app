<?php

namespace App\Services;

use SevenShores\Hubspot\Factory;
use SevenShores\Hubspot\Resources\Contacts;
use SevenShores\Hubspot\Http\Response;

class HubspotContactService
{
    protected $client;

    public function __construct()
    {
        $this->client = Factory::create(config('services.hubspot.api_key'))->getClient();
    }

    public function createContact(string $firstName, string $lastName, string $email) : Response
    {
        $contact = new Contacts($this->client);

        return $contact->create([
            ['property' => 'email',     'value' => $email],
            ['property' => 'firstname', 'value' => $firstName],
            ['property' => 'lastname',  'value' => $lastName],
        ]);
    }
}

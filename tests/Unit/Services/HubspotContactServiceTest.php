<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\User;
use App\Services\HubspotContactService;

class HubspotContactServiceTest extends TestCase
{
    /**
     * @return void
     */
    public function testCreateContact()
    {
        $hubspotContact = new HubspotContactService();
        $user           = User::factory()->make();
        $names          = explode(' ', $user->name);
    
        $response       = $hubspotContact->createContact($names[0], $names[1], $user->email);
        $data           = $response->getData();

        $this->assertEquals($names[0]   , $data->properties->firstname->value);
        $this->assertEquals($names[1]   , $data->properties->lastname->value);
        $this->assertEquals($user->email, $data->properties->email->value);
    }
}

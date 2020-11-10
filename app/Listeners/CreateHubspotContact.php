<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use App\Services\HubspotContactService;

class CreateHubspotContact
{
    /**
     * Handle the event.
     *
     * @param Registered $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $hubspotContact = new HubspotContactService();
        $user           = $event->user;        
        $names          = explode(' ', $user->name);
    
        $hubspotContact->createContact($names[0], $names[1], $user->email);
    }
}

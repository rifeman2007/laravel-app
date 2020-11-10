<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\User $user
     *
     * @return \Illuminate\Auth\Access\Response
     */
    public function payment(User $user)
    {
        if ($user->hasPaymentMethod()) {
            return $this->deny();
        }

        return $this->allow();        
    }
}

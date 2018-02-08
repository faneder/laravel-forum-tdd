<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the given profile
     * @param  User   $signedInUser
     * @param  User   $user
     * @return boolean
     */
    public function update(User $signedInUser, User $user)
    {
        return $user->is($signedInUser);
    }
}

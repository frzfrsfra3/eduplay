<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Language;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    // policy for users and languages
    use HandlesAuthorization;

    // adding languages
    public function addLanguages(User $user)
    {
        //
    }

    // creating users
    public function create(User $user)
    {
        //
    }

    // updating user information
    public function update(User $user)
    {
        // every authenticated user can update his own information
    }

    /**
     * Determine whether the user can delete the model.
     *
     * param  \App\Models\User  $user
     * param  \App\User  $model
     * return mixed
     */
    public function delete(User $user, User $model)
    {
        //
    }
}

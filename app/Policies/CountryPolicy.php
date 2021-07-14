<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Country;
use Illuminate\Auth\Access\HandlesAuthorization;

class CountryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the country.
     *
     * param  \App\Models\User  $user
     * param  \App\Country  $country
     * return mixed
     */
    public function view(User $user, Country $country)
    {
        //
        return $user->hasRole('Admin');
    }

    /**
     * Determine whether the user can create countries.
     *
     * param  \App\Models\User  $user
     * return mixed
     */
    public function doadminwork(User $user)
    {
        return $user->hasRole('Admin');
    }

    /**
     * Determine whether the user can update the country.
     *
     * param  \App\Models\User  $user
     * param  \App\Country  $country
     * return mixed
     */
    public function update(User $user, Country $country)
    {
        //
    }

    /**
     * Determine whether the user can delete the country.
     *
     * param  \App\Models\User  $user
     * param  \App\Country  $country
     * return mixed
     */
    public function delete(User $user, Country $country)
    {
        //
    }
}

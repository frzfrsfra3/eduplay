<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Badge;
use Illuminate\Auth\Access\HandlesAuthorization;

class BadgePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the badge.
     *
     * param  \App\Models\User  $user
     * param  \App\Badge  $badge
     * return mixed
     */
    public function view(User $user, Badge $badge)
    {
        //
    }

    /**
     * Determine whether the user can create badges.
     *
     * param  \App\Models\User  $user
     * return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the badge.
     *
     * param  \App\Models\User  $user
     * param  \App\Badge  $badge
     * return mixed
     */
    public function update(User $user, Badge $badge)
    {
        //
    }

    /**
     * Determine whether the user can delete the badge.
     *
     * param  \App\Models\User  $user
     * param  \App\Badge  $badge
     * return mixed
     */
    public function delete(User $user, Badge $badge)
    {
        //
    }
}

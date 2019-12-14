<?php

namespace App\Policies;

use App\User;
use App\Org;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrgPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any hotels.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
        return true;
    }

    /**
     * Determine whether the user can view the hotel.
     *
     * @param  \App\User  $user
     * @param  \App\Org  $org
     * @return mixed
     */
    public function view(User $user, Org $org)
    {
        //
        return true;
    }

    /**
     * Determine whether the user can create hotels.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
        return $user ? true : false;
    }

    /**
     * Determine whether the user can update the hotel.
     *
     * @param  \App\User  $user
     * @param  \App\Org  $org
     * @return mixed
     */
    public function update(User $user, Org $org)
    {
        //
        return $org->org_group->owner_id == $user->id;
    }

    /**
     * Determine whether the user can delete the hotel.
     *
     * @param  \App\User  $user
     * @param  \App\Org  $org
     * @return mixed
     */
    public function delete(User $user, Org $org)
    {
        //
        return $org->org_group->owner_id == $user->id;
    }

    /**
     * Determine whether the user can restore the hotel.
     *
     * @param  \App\User  $user
     * @param  \App\Org  $org
     * @return mixed
     */
    public function restore(User $user, Org $org)
    {
        //
        return false;
    }

    /**
     * Determine whether the user can permanently delete the hotel.
     *
     * @param  \App\User  $user
     * @param  \App\Org  $org
     * @return mixed
     */
    public function forceDelete(User $user, Org $org)
    {
        //
        return false;
    }
}

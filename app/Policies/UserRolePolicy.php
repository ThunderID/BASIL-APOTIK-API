<?php

namespace App\Policies;

use App\User;
use App\UserRole;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserRolePolicy
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
     * @param  \App\UserRole  $role
     * @return mixed
     */
    public function view(User $user, UserRole $role)
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
    public function create(User $user, UserRole $role)
    {
        $org = $role->org;
        if (!$org) return false;

        if ($org->org_group->owner_id == $user->id) return true;

        $work = $user->works_in_hotel->firstWhere('org_id', '=', $role->org_id);
        if ($work && array_intersect($work->scopes, ['*', 'ROLE']))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Determine whether the user can update the hotel.
     *
     * @param  \App\User  $user
     * @param  \App\UserRole  $role
     * @return mixed
     */
    public function update(User $user, UserRole $role)
    {
        $org = $role->org;
        if (!$org) return false;

        if ($org->org_group->owner_id == $user->id) return true;

        $work = $user->works_in_hotel->firstWhere('org_id', '=', $role->org_id);
        if ($work && array_intersect($work->scopes, ['*', 'ROLE']))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Determine whether the user can delete the hotel.
     *
     * @param  \App\User  $user
     * @param  \App\UserRole  $role
     * @return mixed
     */
    public function delete(User $user, UserRole $role)
    {
        $org = $role->org;
        if (!$org) return false;

        if ($org->org_group->owner_id == $user->id) return true;

        $work = $user->works_in_hotel->firstWhere('org_id', '=', $role->org_id);
        if ($work && array_intersect($work->scopes, ['*', 'ROLE']))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Determine whether the user can restore the hotel.
     *
     * @param  \App\User  $user
     * @param  \App\UserRole  $role
     * @return mixed
     */
    public function restore(User $user, UserRole $role)
    {
        //
        return false;
    }

    /**
     * Determine whether the user can permanently delete the hotel.
     *
     * @param  \App\User  $user
     * @param  \App\UserRole  $role
     * @return mixed
     */
    public function forceDelete(User $user, UserRole $role)
    {
        //
        return false;
    }
}

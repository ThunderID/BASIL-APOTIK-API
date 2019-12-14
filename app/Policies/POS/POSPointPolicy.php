<?php

namespace App\Policies\POS;

use App\User;
use Thunderlabid\POS\POSPoint;
use Illuminate\Auth\Access\HandlesAuthorization;

class POSPointPolicy
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
        return false;
    }

    /**
     * Determine whether the user can view the hotel.
     *
     * @param  \App\User  $user
     * @param  \App\POSPoint  $pos_point
     * @return mixed
     */
    public function view(User $user, POSPoint $pos_point)
    {
        return true;
    }

    /**
     * Determine whether the user can create hotels.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user, POSPoint $pos_point)
    {
        $org  = $pos_point->org;
        if (!$org) return false;

        if ($org->org_group->owner_id == $user->id) return true;

        $work = $user->works_in_hotel->firstWhere('org_id', '=', $pos_point->org_id);
        if ($work && array_intersect($work->scopes, ['*', 'POS*']))
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
     * @param  \App\POSPoint  $pos_point
     * @return mixed
     */
    public function update(User $user, POSPoint $pos_point)
    {
        $org  = $pos_point->org;
        if (!$org) return false;

        if ($org->org_group->owner_id == $user->id) return true;
        
        $work = $user->works_in_hotel->firstWhere('org_id', '=', $pos_point->org_id);
        if ($work && array_intersect($work->scopes, ['*', 'POS*']))
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
     * @param  \App\POSPoint  $pos_point
     * @return mixed
     */
    public function delete(User $user, POSPoint $pos_point)
    {
        $org  = $pos_point->org;
        if (!$org) return false;

        if ($org->org_group->owner_id == $user->id) return true;
        
        $work = $user->works_in_hotel->firstWhere('org_id', '=', $pos_point->org_id);
        if ($work && array_intersect($work->scopes, ['*', 'POS*']))
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
     * @param  \App\POSPoint  $pos_point
     * @return mixed
     */
    public function restore(User $user, POSPoint $pos_point)
    {
        //
        return false;
    }

    /**
     * Determine whether the user can permanently delete the hotel.
     *
     * @param  \App\User  $user
     * @param  \App\POSPoint  $pos_point
     * @return mixed
     */
    public function forceDelete(User $user, POSPoint $pos_point)
    {
        //
        return false;
    }
}

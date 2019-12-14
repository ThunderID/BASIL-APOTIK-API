<?php

namespace App\Policies\Restaurant;

use App\User;
use Thunderlabid\Restaurant\OrderLine;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderLinePolicy
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
     * @param  \App\OrderLine  $line
     * @return mixed
     */
    public function view(User $user, OrderLine $line)
    {
        return true;
    }

    /**
     * Determine whether the user can create hotels.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user, OrderLine $line)
    {
        $org  = $line->order->pos_point->org;
        if (!$org) return false;

        if ($org->org_group->owner_id == $user->id) return true;
        
        $work = $user->works_in_hotel->firstWhere('org_id', '=', $line->order->pos_point->org_id);
        if ($work && array_intersect($work->scopes, ['*', 'ORDER.SUBMIT', 'ORDER.CONFIRM', 'ORDER.DELIVER']))
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
     * @param  \App\OrderLine  $line
     * @return mixed
     */
    public function update(User $user, OrderLine $line)
    {
        $org  = $line->order->pos_point->org;
        if (!$org) return false;

        if ($org->org_group->owner_id == $user->id) return true;
        
        $work = $user->works_in_hotel->firstWhere('org_id', '=', $line->order->pos_point->org_id);
        if ($work && array_intersect($work->scopes, ['*', 'ORDER.SUBMIT', 'ORDER.CONFIRM', 'ORDER.DELIVER']))
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
     * @param  \App\OrderLine  $line
     * @return mixed
     */
    public function delete(User $user, OrderLine $line)
    {
        $org  = $line->order->pos_point->org;
        if (!$org) return false;

        if ($org->org_group->owner_id == $user->id) return true;
        
        $work = $user->works_in_hotel->firstWhere('org_id', '=', $line->order->pos_point->org_id);
        if ($work && array_intersect($work->scopes, ['*', 'ORDER.SUBMIT', 'ORDER.CONFIRM', 'ORDER.DELIVER']))
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
     * @param  \App\OrderLine  $line
     * @return mixed
     */
    public function restore(User $user, OrderLine $line)
    {
        //
        return false;
    }

    /**
     * Determine whether the user can permanently delete the hotel.
     *
     * @param  \App\User  $user
     * @param  \App\OrderLine  $line
     * @return mixed
     */
    public function forceDelete(User $user, OrderLine $line)
    {
        //
        return false;
    }
}

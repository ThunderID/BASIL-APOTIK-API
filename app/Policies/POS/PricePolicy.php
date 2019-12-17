<?php

namespace App\Policies\POS;

use App\User;
use Thunderlabid\POS\Price;
use Illuminate\Auth\Access\HandlesAuthorization;

class PricePolicy
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
     * @param  \App\Price  $price
     * @return mixed
     */
    public function view(User $user, Price $price)
    {
        return true;
    }

    /**
     * Determine whether the user can create hotels.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user, Price $price)
    {
        $org  = $price->product->org;
        if (!$org) return false;

        if ($org->org_group->owner_id == $user->id) return true;
        
        $work = $user->works_in_org->firstWhere('org_id', '=', $price->product->org_id);
        if ($work && array_intersect($work->scopes, ['*', 'POS*', 'POS.PRODUCT*']))
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
     * @param  \App\Price  $price
     * @return mixed
     */
    public function update(User $user, Price $price)
    {
        $org  = $price->product->org;
        if (!$org) return false;

        if ($org->org_group->owner_id == $user->id) return true;

        $work = $user->works_in_org->firstWhere('org_id', '=', $price->product->org_id);
        if ($work && array_intersect($work->scopes, ['*', 'POS*', 'POS.PRODUCT*']))
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
     * @param  \App\Price  $price
     * @return mixed
     */
    public function delete(User $user, Price $price)
    {
        $org  = $price->product->org;
        if (!$org) return false;

        if ($org->org_group->owner_id == $user->id) return true;

        $work = $user->works_in_org->firstWhere('org_id', '=', $price->product->org_id);
        if ($work && array_intersect($work->scopes, ['*', 'POS*', 'POS.PRODUCT*']))
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
     * @param  \App\Price  $price
     * @return mixed
     */
    public function restore(User $user, Price $price)
    {
        //
        return false;
    }

    /**
     * Determine whether the user can permanently delete the hotel.
     *
     * @param  \App\User  $user
     * @param  \App\Price  $price
     * @return mixed
     */
    public function forceDelete(User $user, Price $price)
    {
        //
        return false;
    }
}

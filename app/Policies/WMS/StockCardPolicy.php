<?php

namespace App\Policies\WMS;

use App\User;
use Thunderlabid\WMS\StockCard;
use Illuminate\Auth\Access\HandlesAuthorization;

class StockCardPolicy
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
     * @param  \App\StockCard  $stock_card
     * @return mixed
     */
    public function view(User $user, StockCard $stock_card)
    {
        return true;
    }

    /**
     * Determine whether the user can create hotels.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user, StockCard $stock_card)
    {
        $org = $stock_card->warehouse->org;
        if (!$org) return false;

        if ($org->org_group->owner_id == $user->id) return true;

        $work = $user->works_in_org->firstWhere('org_id', '=', $stock_card->warehouse->org_id);
        if ($work && array_intersect($work->scopes, ['*', 'WMS*']))
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
     * @param  \App\StockCard  $stock_card
     * @return mixed
     */
    public function update(User $user, StockCard $stock_card)
    {
        $org = $stock_card->warehouse->org;
        if (!$org) return false;

        if ($org->org_group->owner_id == $user->id) return true;

        $work = $user->works_in_org->firstWhere('org_id', '=', $stock_card->warehouse->org_id);
        if ($work && array_intersect($work->scopes, ['*', 'WMS*']))
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
     * @param  \App\StockCard  $stock_card
     * @return mixed
     */
    public function delete(User $user, StockCard $stock_card)
    {
        $org = $stock_card->warehouse->org;
        if (!$org) return false;

        if ($org->org_group->owner_id == $user->id) return true;

        $work = $user->works_in_org->firstWhere('org_id', '=', $stock_card->warehouse->org_id);
        if ($work && array_intersect($work->scopes, ['*', 'WMS*']))
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
     * @param  \App\StockCard  $stock_card
     * @return mixed
     */
    public function restore(User $user, StockCard $stock_card)
    {
        //
        return false;
    }

    /**
     * Determine whether the user can permanently delete the hotel.
     *
     * @param  \App\User  $user
     * @param  \App\StockCard  $stock_card
     * @return mixed
     */
    public function forceDelete(User $user, StockCard $stock_card)
    {
        //
        return false;
    }
}

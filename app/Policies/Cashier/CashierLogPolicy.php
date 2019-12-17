<?php

namespace App\Policies\Cashier;

use App\User;
use Thunderlabid\Cashier\CashierLog;
use Illuminate\Auth\Access\HandlesAuthorization;

class CashierLogPolicy
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
     * @param  \App\CashierLog  $cashier_log
     * @return mixed
     */
    public function view(User $user, CashierLog $cashier_log)
    {
        return true;
    }

    /**
     * Determine whether the user can create hotels.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user, CashierLog $cashier_log)
    {
        //1. yang buka kasir dan yang login adalah orang yang sama
        if($user->id != $cashier_log->cashier_session->user_id){
            return false;
        }
        //2. yang buka kasir terdaftar di org tsb sbg kasir / owner
        $org = $cashier_log->cashier_session->org;
        if (!$org) return false;

        if ($org->org_group->owner_id == $user->id) return true;

        $work = $user->works_in_org->firstWhere('org_id', '=', $cashier_log->cashier_session->org_id);
        if ($work && array_intersect($work->scopes, ['*', 'POS.INVOICE', 'POS.SETTLEMENT', 'RESERVATION*', 'RECEPTION*', 'OFFICIAL_RECEIPT*', 'PAID_OUT*']))
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
     * @param  \App\CashierLog  $cashier_log
     * @return mixed
     */
    public function update(User $user, CashierLog $cashier_log)
    {
        //1. yang buka kasir dan yang login adalah orang yang sama
        if($user->id != $cashier_log->cashier_session->user_id){
            return false;
        }
        //2. yang buka kasir terdaftar di org tsb sbg kasir / owner
        $org = $cashier_log->cashier_session->org;
        if (!$org) return false;

        if ($org->org_group->owner_id == $user->id) return true;

        $work = $user->works_in_org->firstWhere('org_id', '=', $cashier_log->cashier_session->org_id);
        if ($work && array_intersect($work->scopes, ['*', 'POS.INVOICE', 'POS.SETTLEMENT', 'RESERVATION*', 'RECEPTION*', 'OFFICIAL_RECEIPT*', 'PAID_OUT*']))
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
     * @param  \App\CashierLog  $cashier_log
     * @return mixed
     */
    public function delete(User $user, CashierLog $cashier_log)
    {
        //
        return false;
    }

    /**
     * Determine whether the user can restore the hotel.
     *
     * @param  \App\User  $user
     * @param  \App\CashierLog  $cashier_log
     * @return mixed
     */
    public function restore(User $user, CashierLog $cashier_log)
    {
        //
        return false;
    }

    /**
     * Determine whether the user can permanently delete the hotel.
     *
     * @param  \App\User  $user
     * @param  \App\CashierLog  $cashier_log
     * @return mixed
     */
    public function forceDelete(User $user, CashierLog $cashier_log)
    {
        //
        return false;
    }
}

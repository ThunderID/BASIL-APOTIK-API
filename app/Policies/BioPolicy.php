<?php

namespace App\Policies;

use App\Bio;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BioPolicy
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
     * @param  \App\User  $user
     * @return mixed
     */
    public function view(User $user, Bio $model)
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
    public function create(User $user, Bio $model)
    {
        return true;
        if($user->id == $model->user_id){
            return true;
        }elseif($user && is_null($model->user_id)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the hotel.
     *
     * @param  \App\User  $user
     * @param  \App\User  $user
     * @return mixed
     */
    public function update(User $user, Bio $model)
    {
        return true;
        if($user->id == $model->user_id){
            return true;
        }elseif($user && is_null($model->user_id)){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the hotel.
     *
     * @param  \App\User  $user
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete(User $user, Bio $model)
    {
        //
        return false;
    }

    /**
     * Determine whether the user can restore the hotel.
     *
     * @param  \App\User  $user
     * @param  \App\User  $user
     * @return mixed
     */
    public function restore(User $user, Bio $model)
    {
        //
        return false;
    }

    /**
     * Determine whether the user can permanently delete the hotel.
     *
     * @param  \App\User  $user
     * @param  \App\User  $user
     * @return mixed
     */
    public function forceDelete(User $user, Bio $model)
    {
        //
        return false;
    }
}

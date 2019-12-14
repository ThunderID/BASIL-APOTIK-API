<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Validation\Rule;
use Hash;

use Illuminate\Validation\ValidationException;

use Thunderlabid\Restaurant\Order;

class User extends Authenticatable
{
    // --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    // TRAITS
    // --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    use Notifiable;
    

    // --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    // VARIABLES
    // --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'username_verified_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];




    // --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    // CONFIGURATIONS
    // --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    
    // --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    // BOOT
    // --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    
    // --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    // CONSTRUCT
    // --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    
    // --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    // RELATIONSHIP
    // --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    public function org_groups()
    {
        return $this->hasMany(OrgGroup::class, 'owner_id')->orderBy('name');
    }

    public function partners()
    {
        return $this->hasMany(Partner::class, 'pr_id')->orderBy('name');
    }

    public function orgs() {
        return $this->hasManyThrough(Org::class, OrgGroup::class, 'owner_id', 'org_group_id')->orderBy('name');
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }

    public function works_in_hotel()
    {
        return $this->hasMany(UserRole::class, 'user_id')
        ->where(function($q){
            $q->whereNull('ended_at')
            ->orWhere('ended_at', '>', now());
        });
    }

    // public function all_works_in_hotel()
    // {
    //     return $this->hasMany(Work::class, 'user_id')
    //     ->where('org_type', '=', get_class(app()->make(Org::class)));
    // }

    public function reset_password_token()
    {
        return $this->hasOne(UserToken::class)->where('type', UserToken::RESET_PASSWORD);
    }

    public function activation_token()
    {
        return $this->hasOne(UserToken::class)->where('type', UserToken::ACTIVATION);
    }
    
    public function tokens()
    {
        return $this->hasMany(UserToken::class);
    }
    
    public function bio()
    {
        return $this->hasOne(Bio::class);
    }
    
    public function stays()
    {
        return $this->hasMany(\App\Models\Record\UserStay::class);
    }

    public function receptions()
    {
        return $this->hasMany(\App\Models\Record\Reception::class);
    }

    public function roles(){
        return $this->hasMany(UserRole::class);
    }

    public function memberships(){
        return $this->hasMany(\App\Models\Membership\Membership::class);
    }

    public function membership($org_group_id = null){
        if(!is_null($org_group_id)){
            return $this->hasOne(\App\Models\Membership\Membership::class)->where('org_group_id', $org_group_id);
        }
        return $this->hasOne(\App\Models\Membership\Membership::class);
    }

    // --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    // BOOT
    // --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    
    // --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    // STATIC FUNCTION
    // --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    public static function authenticate(String $username, String $password)
    {
        $user = Static::username($username)->first();
        if (!$user) throw ValidationException::withMessages(['username' => 'invalid']);;

        if (app('hash')->check($password, $user->password))
        {
            return $user;
        }
        else
        {
            throw ValidationException::withMessages(['password' => 'invalid']);;
        }
    }
    
    // --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    // FUNCTION
    // --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    public function getRules()
    {
        return [
            'name'                 => ['required', 'string', 'max:255'],
            'email'                => ['nullable', 'email'],
            'username'             => ['required', 'numeric', Rule::unique($this->getTable())->ignore($this->id), 'digits_between:10,20'],
            'username_verified_at' => ['nullable', 'date'],
            'password'             => ['required', 'string', 'min:8'],
        ];
    }

    public function encryptPassword()
    {
        if (app('hash')->needsRehash($this->attributes['password']))
        {
            $this->attributes['password'] = app('hash')->make($this->attributes['password']);
        }
    }

    public function resetPasswordWithToken(String $token, String $password) : bool
    {
        $reset_password_token = $this->reset_password_token;
        if  (
            $reset_password_token && 
            $reset_password_token->expired_at->gte(now()) && 
            $reset_password_token->token == $token
        )
        {
            $this->attributes['password'] = $password;
            $this->save();

            $reset_password_token->delete();
            return true;
        }
        else
        {
            return false;
        }
    }

    public function createResetPasswordToken() : UserToken
    {
        $this->reset_password_token()->delete();

        $token = $this->reset_password_token()->create([
            'type'       => UserToken::RESET_PASSWORD,
            'token'      => UserToken::generateToken(),
            'expired_at' => now()->addMinutes(config('token.reset_password_duration'))
        ]);

        return $token;
    }

    public function createActivationToken() : UserToken
    {
        $token = $this->activation_token;

        // Delete Old Token
        if ($token) $token->delete();

        // Create new token
        $token = $this->activation_token()->create([
            'type'       => UserToken::ACTIVATION,
            'token'      => UserToken::generateToken(),
            'expired_at' => now()->addMinutes(config('token.activation_duration'))
        ]);

        return $token;
    }

    public function checkPassword(String $password = null) : bool
    {
        return (Hash::check($password, $this->attributes['password']));
    }

    // --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    // ACCESSOR
    // --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    public function getIsCustomerAttributes()
    {
        return true;
    }

    // --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    // MUTATOR
    // --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    
    // --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    // QUERY
    // --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    public function scopeName($q, String $v)
    {
        return $q->where('name', 'like', $v);
    }

    public function scopeUsername($q, String $v)
    {
        return $q->where('username', '=', $v);
    }

    public function scopeHasOrgGroup($q)
    {
        return $q->has('org_groups');
    }
}

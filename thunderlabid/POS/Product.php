<?php

namespace Thunderlabid\POS;

// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// LARAVEL
// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
use App\Product as Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Product extends Model{

	public function price()
	{
		return $this->hasOne(get_class(app()->make(Price::class)))->activeAtLte(now())->latest('active_at')->latest('created_at');
	}

	public function prices()
	{
		return $this->hasMany(get_class(app()->make(Price::class)))->latest('active_at')->latest('created_at');
	}

	public function setCodeAttribute(String $code)
	{
		$this->attributes['code'] = strtoupper($code);
	}

	public function scopeCode ($q, String $v) 
	{
		return $q->where('code', 'like', str_replace('*', '%', $v));
	}

	public function scopeName ($q, String $v) 
	{
		return $q->where('name', 'like', str_replace('*', '%', $v));
	}

	public function scopeIsAvailable($q, Bool $v = null)
	{
		if (isset($v))
		{
			$q->where('is_available', '=', $v);
		}
	}

	public function scopeHasDiscount($q, Bool $v = null)
	{
		if (isset($v))
		{
			$q->where('discount', '>', 0);
		}
	}
}
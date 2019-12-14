<?php

namespace Thunderlabid\POS;

// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// LARAVEL
// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Product extends Model
{
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// TRAITS
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// VARIABLES
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	protected $table = 'POS_products';
	public $timestamps = true;
	protected $fillable = [
		'pos_point_id',
		'code',
		'name',
		'group',
		'description',
		'is_available',
	];

	protected $hidden = [
	];

	protected $casts = [
	];

	protected $dates = [
		'deleted_at'
	];

	protected $touches = [
	];

	protected $observables = [
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
	public function pos_point()
	{
		return $this->belongsTo(get_class(app()->make(POSPoint::class)), 'pos_point_id');
	}
	
	public function price()
	{
		return $this->hasOne(get_class(app()->make(Price::class)))->activeAtLte(now())->latest('active_at')->latest('created_at');
	}

	public function prices()
	{
		return $this->hasMany(get_class(app()->make(Price::class)))->latest('active_at')->latest('created_at');
	}

	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// BOOT
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// STATIC FUNCTION
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// FUNCTION
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	public function getRules()
	{
		$rules['pos_point_id'] = ['required', 'exists:' . app()->make(POSPoint::class)->getTable() . ',id'];
		$rules['code']         = ['required', Rule::unique($this->table)->ignore($this->id)];
		// $rules['name']         = ['required', Rule::unique($this->table)->ignore($this->id)];
		$rules['name']  	  	= ['required', 'string'];
		$rules['group']  	  	= ['required', 'string'];
		$rules['description']  	= ['nullable', 'string'];
		$rules['is_available'] 	= ['required', 'boolean'];
		
		return $rules;
	}
	
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// ACCESSOR
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// MUTATOR
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	public function setCodeAttribute(String $code)
	{
		$this->attributes['code'] = strtoupper($code);
	}

	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// QUERY
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
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
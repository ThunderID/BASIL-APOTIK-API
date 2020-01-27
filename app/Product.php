<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use DB;

class Product extends Model
{
    // --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// TRAITS
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// VARIABLES
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	protected $table = 'products';
	
	protected $fillable = [
		'org_id',
		'name',
		'code',
		'group',
		'description',
		'threshold',
		'unit',
	];

	public $timestamps = true;

	protected $hidden = [
	];

	protected $casts = [
	];

	protected $dates = [
		'deleted_at'
	];

	protected $touches = [
	];

	const GROUP = [
		'DRUG', 'ALCOHOL', 'GENERIC'
	];

	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// BOOT
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// CONSTRUCT
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// RELATIONSHIP
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	public function org() {
		return $this->belongsTo(\App\Org::class);
	}

    public function stock_cards() {
        return $this->hasMany(StockCard::class);
    }
	public function price()
	{
		return $this->hasOne(Price::class)->activeAtLte(now())->latest('active_at')->latest('created_at');
	}

	public function prices()
	{
		return $this->hasMany(Price::class)->latest('active_at')->latest('created_at');
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
		$rules['org_id']	= ['required', 'integer', 'exists:'. app()->make(\App\Org::class)->getTable() . ',id'];
		$rules['name']		= ['required', 'string', Rule::unique($this->getTable())->ignore($this->id)->where(function($q) { $q->where('org_id', '=', $this->org_id ? $this->org_id : -1); } ) ];
		$rules['code']		= ['required', 'string', Rule::unique($this->getTable())->ignore($this->id)->where(function($q) { $q->where('org_id', '=', $this->org_id ? $this->org_id : -1); } ) ];
		// $rules['group']					= ['required', 'string', 'in:'.implode(',', SELF::GROUP)];
		$rules['group']					= ['required', 'string'];
		$rules['description']			= ['nullable', 'string'];
		$rules['threshold']				= ['nullable', 'numeric', 'min:0'];
		$rules['unit']					= ['nullable', 'string'];

		return $rules;
	}
	
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// ACCESSOR
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// MUTATOR
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// QUERY
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	public function scopeName ($q, String $v) 
	{
		return $q->where('name', 'like', str_replace('*', '%', $v));
	}
}

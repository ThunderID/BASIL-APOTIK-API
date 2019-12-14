<?php

namespace Thunderlabid\POS;

// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// LARAVEL
// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Price extends Model
{
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// TRAITS
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// VARIABLES
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	protected $table = 'POS_prices';
	public $timestamps = true;
	protected $fillable = [
		'product_id',
		'active_at',
		'price',
		'discount',
	];

	protected $hidden = [
	];

	protected $casts = [
	];

	protected $dates = [
		'deleted_at', 'active_at'
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
	public function product()
	{
		return $this->belongsTo(get_class(app()->make(Product::class)));
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
		$rules['product_id']   = ['required', 'exists:' . app()->make(Product::class)->getTable() . ',id'];
		$rules['active_at']    = ['required', 'date', 'after_or_equal:today'];
		$rules['price']        = ['required', 'numeric', 'gte:0'];
		$rules['discount']     = ['required', 'numeric', 'gte:0', 'lte:' . $this->price];
		
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
	public function scopeProductId ($q, Int $v) 
	{
		return $q->where('product_id', '=', $v);
	}

	public function scopeActiveAtLt ($q, \Carbon\Carbon $v) 
	{
		return $q->where('active_at', '<', $v);
	}

	public function scopeActiveAtLte ($q, \Carbon\Carbon $v) 
	{
		return $q->where('active_at', '<=', $v);
	}

	public function scopeActiveAtGt ($q, \Carbon\Carbon $v) 
	{
		return $q->where('active_at', '>', $v);
	}

	public function scopeActiveAtGte ($q, \Carbon\Carbon $v) 
	{
		return $q->where('active_at', '>=', $v);
	}
}
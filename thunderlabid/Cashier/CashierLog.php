<?php

namespace Thunderlabid\Cashier;

use Illuminate\Database\Eloquent\Model;

class CashierLog extends Model
{
    // --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// TRAITS
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// VARIABLES
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	protected $fillable = [
		'cashier_session_id',
		'method',
		'amount',
		'ref_id',
		'ref_type',
	];

	public $timestamps = true;

	protected $hidden = [
	];

	protected $casts = [
	];

	protected $dates = [
		'deleted_at',
	];

	protected $touches = [
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
	public function cashier_session()
	{
		return $this->belongsTo(CashierSession::class);
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
		$rules['cashier_session_id']	= ['required', 'exists:' . app()->make(CashierSession::class)->getTable() . ',id' ];
		$rules['method'] 	= ['required', 'in:'.implode(',', config()->get('cashier.settlement_method'))];
		$rules['amount'] 	= ['required', 'numeric'];
		$rules['ref_id']    = ['nullable', 'numeric'];
		$rules['ref_type']  = ['nullable', 'string'];
		
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
}

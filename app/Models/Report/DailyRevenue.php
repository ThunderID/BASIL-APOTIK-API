<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Model;

class DailyRevenue extends Model
{
    // --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// TRAITS
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// VARIABLES
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	protected $fillable = [
		'org_id',
		'date',
		'ref_id',
		'ref_type',
		'division',
		'sub_division',
		'item',
		'amount',
	];

	public $timestamps = true;

	protected $hidden = [
	];

	protected $casts = [
	];

	protected $dates = [
		'deleted_at',
		'date',
	];

	protected $touches = [
	];

	protected $observables = [
	];

	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// CONFIGURATIONS
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	const DIVISION = [
		'ROOM', 'FNB'
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
		$rules['org_id']		= ['required', 'exists:' . app()->make(\App\Org::class)->getTable() . ',id'];
		$rules['date']			= ['nullable', 'after_or_equal:today'];
		$rules['ref_id']		= ['required', 'int'];
		$rules['ref_type']		= ['required', 'string'];

		$rules['division']		= ['required', 'string'];
		$rules['sub_division']	= ['nullable', 'string'];
		$rules['item']			= ['required', 'string'];
		$rules['amount']		= ['nullable', 'numeric', 'min:0'];

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

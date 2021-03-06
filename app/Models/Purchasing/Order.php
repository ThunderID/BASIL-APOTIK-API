<?php

namespace App\Models\Purchasing;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// TRAITS
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// VARIABLES
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	protected $table = 'purchasing_orders';
	protected $fillable = [
		'org_id',
		'partner_id',
		'no',
		'date',
		'lines',
		'tenders',
		'closed_at',
		'created_by',
		'approved_by',
		'approved_at',
	];

	public $timestamps = true;

	protected $hidden = [
	];

	protected $casts = [
		'lines'		=> 'array',
		'tenders'	=> 'array',
	];

	protected $dates = [
		'deleted_at',
		'date',
		'closed_at'
	];

	protected $touches = [
	];

	protected $observables = [
	];

	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// CONFIGURATIONS
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	CONST TYPE 		= ['MARKET_LIST', 'PURCHASE_REQUEST'];

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
		return $this->belongsTo(\App\User::class);
	}

	public function partner() {
		return $this->belongsTo(\App\Partner::class);
	}

	public function creator() {
		return $this->belongsTo(\App\User::class, 'created_by');
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
		$rules['org_id']		= ['required', 'exists:' . app()->make(\App\Org::class)->getTable() . ',id'];
		$rules['partner_id']	= ['required', 'exists:' . app()->make(\App\Partner::class)->getTable() . ',id'];
		$rules['no']			= ['nullable', 'string'];
		$rules['type']			= ['required', 'string'];
		$rules['date']			= ['nullable', 'after_or_equal:today'];
		$rules['lines']			= ['required', 'array'];
		
		$rules['lines.*.product_id']	= ['required', 'int', 'exists:' . app()->make(\App\Product::class)->getTable() . ',id'];
		$rules['lines.*.qty']			= ['required', 'numeric'];

		$rules['lines.*.tenders.partner_id']	= ['nullable', 'int', 'exists:' . app()->make(\App\Partner::class)->getTable() . ',id'];
		$rules['lines.*.tenders.price']			= ['nullable', 'numeric'];
		$rules['lines.*.tenders.discount']		= ['nullable', 'numeric'];

		$rules['closed_at']		= ['nullable', 'after_or_equal:date'];

		$rules['created_by'] 	= ['required', 'integer', 'exists:'. app()->make(\App\User::class)->getTable() . ',id'];
		$rules['approved_by'] 	= ['nullable', 'integer', 'exists:'. app()->make(\App\User::class)->getTable() . ',id'];
		$rules['approved_at']	= ['required_with:approved_by', 'date'];
		
		return $rules;
	}
	
	public function generateNo() {
		$prefix 	= str_pad($this->org_id, 4, '0', STR_PAD_LEFT).'.'.now()->format('ym');
		$idx 		= Order::where('no', 'like', $prefix.'%')->count() + 1;
		do{
			$no 	= $prefix.'.'.str_pad($idx, 4, '0', STR_PAD_LEFT);
			$exists	= Order::where('no', $no)->first();
			$idx++;
		}while ($exists);
		
		return $no;
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

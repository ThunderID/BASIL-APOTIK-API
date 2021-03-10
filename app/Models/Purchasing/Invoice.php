<?php

namespace App\Models\Purchasing;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Invoice extends Model
{
    // --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// TRAITS
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// VARIABLES
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	protected $table = 'purchasing_invoices';
	protected $fillable = [
		'org_id',
		'partner_id',
		'no',
		'issued_at',
		'lines',
		'taxes',
	];

	public $timestamps = true;

	protected $hidden = [
	];

	protected $casts = [
		'lines'	=> 'array',
		'taxes'	=> 'array',
	];

	protected $dates = [
		'deleted_at',
		'issued_at',
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
	public function org() {
		return $this->belongsTo(\App\Org::class);
	}

	public function partner() {
		return $this->belongsTo(\App\Partner::class);
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
		$rules['partner_id']	= ['nullable', 'exists:' . app()->make(\App\Partner::class)->getTable() . ',id'];
		$rules['no']			= ['nullable', 'string'];
		$rules['issued_at']		= ['nullable', 'before_or_equal:now'];

		$rules['lines']			= ['required', 'array'];
		$rules['lines.*.product_id']	= ['required', 'numeric'];
		$rules['lines.*.qty']			= ['required', 'numeric'];
		$rules['lines.*.price']			= ['required', 'numeric'];
		$rules['lines.*.discount']		= ['required', 'numeric'];
		
		return $rules;
	}
	
	public function generateNo() {
		$prefix 	= str_pad($this->org_id, 4, '0', STR_PAD_LEFT).'.'.now()->format('ym');
		$idx 		= Invoice::where('no', 'like', $prefix.'%')->count() + 1;
		do{
			$no 	= $prefix.'.'.str_pad($idx, 4, '0', STR_PAD_LEFT);
			$exists	= Invoice::where('no', $no)->first();
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
	public function scopeIssuedToday($q, $date){
		return $q->where('issued_at', '<=', Carbon::parse($date)->endofday())->where('issued_at', '>=', Carbon::parse($date)->startofday());
	}
}
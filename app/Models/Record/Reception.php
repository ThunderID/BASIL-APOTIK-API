<?php

namespace App\Models\Record;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use DB;

class Reception extends Model
{
	use SoftDeletes;
    // --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// TRAITS
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// VARIABLES
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	protected $table = 'receptions';

	protected $fillable = [
		'user_id',
		'org_id',
		'booking_id',
		'partner_id',
		'no_ref',
		'cp_name',
		'cp_phone',
		'ci_date',
		'co_date',
		'min_deposit',
		'deposit_instruction',
		'designation',
		'note',
	];

	public $timestamps = true;

	protected $hidden = [
	];

	protected $casts = [
		'lines'	=> 'array',
	];

	protected $dates = [
		'deleted_at',
		'expired_at',
		'ci_date',
		'co_date',
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
	CONST DEPOSIT_INSTRUCTION = \App\Models\Focashier\Invoice::BILLING_INSTRUCTION;
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// RELATIONSHIP
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	public function user() {
		return $this->belongsTo(\App\User::class, 'user_id');
	}

	public function org() {
		return $this->belongsTo(\App\Org::class, 'org_id');
	}

	public function partner() {
		return $this->belongsTo(\App\Partner::class, 'partner_id');
	}

	public function deposits() {
		return $this->hasMany(Deposit::class, 'reception_id');
	}

	public function ga_entries() {
		return $this->hasMany(GAEntry::class, 'reception_id');
	}

	public function room_services() {
		return $this->hasManyThrough(RoomService::class, ReceptionLine::class, 'reception_id', 'reception_line_id', 'reception_id', 'reception_line_id');
	}

	public function lines() {
		return $this->hasMany(ReceptionLine::class, 'reception_id');
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
		$rules['user_id']              = ['required', 'integer', 'exists:' . app()->make(\App\User::class)->getTable() . ',id'];
		$rules['org_id']               = ['required', 'integer', 'exists:' . app()->make(\App\Org::class)->getTable() . ',id'];
		$rules['partner_id']           = ['nullable', 'integer', 'exists:' . app()->make(\App\Partner::class)->getTable() . ',id'];
		$rules['ci_date']              = ['required', 'date', 'after_or_equal:' . now()->startOfDay()];
		$rules['co_date']              = ['required', 'date', 'after:ci_date'];
		$rules['cp_name']              = ['nullable', 'string'];
		$rules['cp_phone']			   = ['nullable', 'string'];
		$rules['no_ref']			   = ['nullable', 'string'];
		$rules['min_deposit']          = ['nullable', 'numeric'];
		$rules['deposit_instruction']  = ['nullable', 'in:'.implode(',', Reception::DEPOSIT_INSTRUCTION)];
		$rules['designation']          = ['nullable', 'string'];
		$rules['note']          	   = ['nullable', 'string'];

		return $rules;
	}

	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// ACCESSOR
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	public function getGABalanceAttribute() {
		return $this->ga_entries->where('invoice_id', null)->sum('amount');
	}

	public function getDepositBalanceAttribute() {
		return $this->deposits->sum('amount');
	}
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// MUTATOR
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// QUERY
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function scopeInHouseAt($q, $var){
		return $q->where('ci_date', '<=', $var)->where('co_date', '>=', $var);
	}
}

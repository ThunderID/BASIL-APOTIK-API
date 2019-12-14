<?php

namespace App\Models\Record;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Voucher extends Model
{
    // --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// TRAITS
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// VARIABLES
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	protected $fillable = [
		'org_id',
		'reception_line_id',
		'user_id',
		'valid_start',
		'valid_until',
		'type',
		'title',
		'code',
		'note',
		'qty',
		'qty_used',
	];

	public $timestamps = true;

	protected $hidden = [
	];

	protected $casts = [
	];

	protected $dates = [
		'deleted_at', 'valid_start', 'valid_until'
	];

	protected $touches = [
	];

	protected $observables = [
	];

	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// CONFIGURATIONS
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	CONST TYPE 		= ['BREAKFAST'];
	CONST BREAKFAST	= 'BREAKFAST';


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

	public function reception_line() {
		return $this->belongsTo(ReceptionLine::class);
	}

	public function user() {
		return $this->belongsTo(\App\User::class);
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
		$rules['org_id']		= ['required', 'integer', 'exists:'. app()->make(\App\Org::class)->getTable() . ',id'];
		$rules['user_id']		= ['nullable', 'integer', 'exists:'. app()->make(\App\User::class)->getTable() . ',id'];
		$rules['reception_line_id']	= ['nullable', 'integer', 'exists:'. app()->make(ReceptionLine::class)->getTable() . ',id'];
		$rules['type']   		= ['required', 'string', 'in:'.implode(',', SELF::TYPE)];
		$rules['valid_start']	= ['required', 'date'];
		$rules['valid_until']	= ['required', 'date'];
		$rules['code']			= ['nullable', 'string'];
		$rules['title']			= ['required', 'string'];
		$rules['qty']			= ['nullable', 'integer'];
		$rules['qty_used']		= ['nullable', 'integer', 'lte:qty'];
		
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

	public function scopeActive($q, $date){
		return $q->Where('qty', '<>', '`qty_used`')->where('valid_start', '>=', Carbon::parse($date)->startofday())
		->where('valid_until', '<=', Carbon::parse($date)->endofday());
	}

	public function scopeCanBeUsed($q, $now){
		return $q->Where('qty', '<>', '`qty_used`')
		->where('valid_start', '<=', $now)
		->where('valid_until', '>=', $now);
	}

	public function generateCode() {
		if(is_null($this->reception_line_id)){
			$prefix 	= $this->org_id.'.'.$this->type.'.'.$this->valid_start->format('Ymd');
			$idx 		= self::where('code', 'like', $prefix.'%')->count() + 1;
			do{
				$code 	= $prefix.'.'.$idx;
				$exists	= self::where('code', $code)->first();
				$idx++;
			}while ($exists);
			
			return $code;
		}
		return $this->org_id.'.'.$this->type.'.'.now()->format('Ymd').'.'.$this->reception_line_id.'.'.$this->user_id;
	}
}

<?php

namespace Thunderlabid\Accounting;

// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// LARAVEL
// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;


class COA extends Model
{
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// TRAITS
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	use SoftDeletes, Traits\Model\HasCustomModelEvent;

	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// VARIABLES
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	protected $table = 'ACCT_coas';
	public $timestamps = true;
	protected $fillable = [
		'org_id',
		'type',
		'code',
		'name',
		'is_archived',
		'is_locked',
		'has_subsidiary',
		'parent_id'
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

	/*======================================
	=            CONFIGURATIONS            =
	======================================*/
	/*----------  TYPE  ----------*/
	const CASH_BANK                 = "Cash & Bank";
	const AR                        = "Account Receivable";
	const INVENTORY                 = "Inventory";
	const FIXED_ASSET               = "Fixed Assets";
	const OTHER_ASSET               = "Other Assets";
	const OTHER_CURRENT_ASSET       = "Other Current Assets";
	const DEPRECIATION_AMORTIZATION = "Depreciation & Amortisation";
	const AP                        = "Account Payable";
	const OTHER_CURRENT_LIABILITIES = "Other Current Liabilities";
	const LONG_TERM_LIABILITIES     = "Long Term Liabilities";
	const EQUITY                    = "Equity";
	const INCOME                    = "Income";
	const OTHER_INCOME              = "Other Income";
	const COGS                      = "Cost Of Sales";
	const EXPENSE                   = "Expenses";
	const OTHER_EXPENSE             = "Other Expenses";

	/*----------  PREFIX  ----------*/
	const PREFIX_CASH_BANK                 = "11-";
	const PREFIX_AR                        = "12-";
	const PREFIX_INVENTORY                 = "13-";
	const PREFIX_FIXED_ASSET               = "14-";
	const PREFIX_OTHER_CURRENT_ASSET       = "15-";
	const PREFIX_OTHER_ASSET               = "16-";
	const PREFIX_DEPRECIATION_AMORTIZATION = "17-";
	const PREFIX_AP                        = "21-";
	const PREFIX_OTHER_CURRENT_LIABILITIES = "22-";
	const PREFIX_LONG_TERM_LIABILITIES     = "23-";
	const PREFIX_EQUITY                    = "31-";
	const PREFIX_INCOME                    = "41-";
	const PREFIX_OTHER_INCOME              = "42-";
	const PREFIX_COGS                      = "43-";
	const PREFIX_EXPENSE                   = "51-";
	const PREFIX_OTHER_EXPENSE             = "52-";

	/*=====  End of CONFIGURATIONS  ======*/
	


	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// BOOT
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// CONSTRUCT
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// RELATIONSHIP
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	public function org()
	{
		return $this->belongsTo(\App\Org::class);
	}

	public function parent()
	{
		return $this->belongsTo(app()->make(COA::class), 'parent_id');
	}

	public function subaccounts()
	{
		return $this->hasMany(app()->make(COA::class), 'parent_id');
	}

	public function subsidiaries()
	{
		return $this->hasMany(app()->make(SubsidiaryCOA::class), 'coa_id');
	}

	// public function journal_entry_lines()
	// {
	// 	return $this->hasMany(app()->make(JournalEntryLine::class), 'coa_id');
	// }

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
		$rules['org_id'] 	= ['required', 'int'];
		$rules['parent_id'] = ['nullable', 'exists:' . $this->getTable() . ',id'];
		$rules['type']      = ['required', 'string', 'in:' . implode(',', [
			Static::CASH_BANK,
			Static::AR,
			Static::INVENTORY,
			Static::FIXED_ASSET,
			Static::OTHER_ASSET,
			Static::OTHER_CURRENT_ASSET,
			Static::DEPRECIATION_AMORTIZATION,
			Static::AP,
			Static::OTHER_CURRENT_LIABILITIES,
			Static::LONG_TERM_LIABILITIES,
			Static::EQUITY,
			Static::INCOME,
			Static::OTHER_INCOME,
			Static::COGS,
			Static::EXPENSE,
			Static::OTHER_EXPENSE,
		])];
		
		$rules['parent_id']      = ['nullable', 'string', 'exists:' . $this->table . ',id'];
		$rules['code']           = ['required', 'string', Rule::unique($this->getTable())->ignore($this->id)];
		$rules['name']           = ['required', 'string', Rule::unique($this->getTable())->ignore($this->id)];
		$rules['is_archived']    = ['boolean'];
		$rules['is_locked']      = ['required', 'boolean'];
		$rules['has_subsidiary'] = ['required', 'boolean'];
		
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
	public function scopeCode ($q, String $v) 
	{
		return $q->where('code', 'like', str_replace('*', '%', $v));
	}

	public function scopeTypeIn ($q, Array $v = []) 
	{
		return $q->whereIn('type', $v);
	}

	public function scopeName ($q, String $v) 
	{
		return $q->where('name', 'like', str_replace('*', '%', $v));
	}

	public function scopeSearch ($q, String $v) 
	{
		return $q->where('name', 'like', str_replace('*', '%', $v))
				 ->orWhere('code', 'like', str_replace('*', '%', $v));
	}
}
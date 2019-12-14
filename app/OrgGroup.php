<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class OrgGroup extends Model
{
    // --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// TRAITS
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// VARIABLES
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	protected $table = 'org_groups';

	protected $fillable = [
		'owner_id',
		'name',
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
	public function owner()
	{
		return $this->belongsTo(User::class, 'owner_id');
	}

	public function orgs()
	{
		return $this->hasMany(Org::class, 'org_group_id')->orderBy('name');
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
		$rules['owner_id'] = ['required', 'exists:' . app()->make(User::class)->getTable() . ',id'];
		$rules['name']     = ['required', 'string', Rule::unique($this->getTable(), 'name')->ignore($this->id)->where(function($q) { $q->where('owner_id', '=', isset($this->owner_id) && $this->owner_id ? $this->owner_id : -1); })];

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
	public function scopeName($q, String $v)
	{
		return $q->where('name', 'like', str_replace('*', '%', $v));
	}

	public function scopeCity($q, String $v)
	{
		return $q->where('city', 'like', str_replace('*', '%', $v));
	}
}

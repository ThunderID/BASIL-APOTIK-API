<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class OrgSetting extends Model
{
    // --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// TRAITS
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// VARIABLES
	// --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	protected $table = 'org_settings';

	protected $fillable = [
		'org_id',
		'active_at',
		'setting',
	];

	public $timestamps = true;

	protected $hidden = [
	];

	protected $casts = [
		'setting'	=> 'array'
	];

	protected $dates = [
		'deleted_at',
		'active_at'
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
	public function org()
	{
		return $this->belongsTo(Org::class, 'org_id');
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
		$rules['org_id'] 		= ['required', 'exists:' . app()->make(Org::class)->getTable() . ',id'];
		$rules['active_at']     = ['required', 'date'];
		$rules['setting']       = ['nullable', 'array'];

		$rules['setting.fo.payment_credit_card']		= ['nullable', 'array'];
		$rules['setting.fo.payment_debit_card']			= ['nullable', 'array'];

		$rules['setting.fo.checkin_in_hour']			= ['required', 'numeric', 'min:0', 'max:23'];
		$rules['setting.fo.checkout_in_hour']			= ['required', 'numeric', 'min:0', 'max:23'];

		$rules['setting.fnb.breakfast_start_in_hour']	= ['required', 'numeric', 'min:0', 'max:23'];
		$rules['setting.fnb.breakfast_end_in_hour']		= ['required', 'numeric', 'min:0', 'max:23'];

		$rules['setting.fo.checkin.*.min_in_hour']		= ['required','numeric', 'min:0', 'max:23'];
		$rules['setting.fo.checkin.*.max_in_hour']		= ['required','numeric', 'min:0', 'max:23'];
		$rules['setting.fo.checkin.*.amount']			= ['required','numeric'];
		$rules['setting.fo.checkin.*.breakfast']		= ['required','boolean'];

		$rules['setting.fo.checkout.*.min_in_hour']		= ['required','numeric', 'min:0', 'max:23'];
		$rules['setting.fo.checkout.*.max_in_hour']		= ['required','numeric', 'min:0', 'max:23'];
		$rules['setting.fo.checkout.*.amount']			= ['required','numeric'];

		$rules['setting.fo.cancellation.*.min_in_hour']	= ['required','numeric'];
		$rules['setting.fo.cancellation.*.max_in_hour']	= ['required','numeric'];
		$rules['setting.fo.cancellation.*.percentage']	= ['required','numeric', 'min:0', 'max:100'];

		$rules['setting.fo.normal_rate']				= ['required','numeric'];
		$rules['setting.fo.weekend_rate']				= ['required','numeric'];
		$rules['setting.fo.ota_normal_rate']			= ['required','numeric'];
		$rules['setting.fo.ota_weekend_rate']			= ['required','numeric'];

		$rules['setting.fnb.breakfast_normal_rate']		= ['required','numeric'];
		$rules['setting.fnb.breakfast_weekend_rate']	= ['required','numeric'];

		$rules['setting.membership.partner.*.min']			= ['nullable','numeric'];
		$rules['setting.membership.partner.*.max']			= ['nullable','numeric'];
		$rules['setting.membership.partner.*.level']		= ['required','string'];
		
		$rules['setting.membership.partner.*.gain_in_money']= ['required','numeric'];
		$rules['setting.membership.partner.*.log_in_money']	= ['required','numeric'];

		$rules['setting.membership.guest.*.min']			= ['nullable','numeric'];
		$rules['setting.membership.guest.*.max']			= ['nullable','numeric'];
		$rules['setting.membership.guest.*.level']			= ['required','string'];
		
		$rules['setting.membership.guest.*.gain_in_money'] 	= ['required','numeric'];
		$rules['setting.membership.guest.*.log_in_money']	= ['required','numeric'];

		$rules['setting.fo.rate.*.min_occupancy_in_percentage']		= ['required','numeric', 'min:0', 'max:100'];
		$rules['setting.fo.rate.*.max_occupancy_in_percentage']		= ['required','numeric', 'min:0', 'max:100'];
		$rules['setting.fo.rate.*.increase_rate_in_percentage']		= ['required','numeric', 'min:0', 'max:100'];
		
		$rules['setting.target.monthly_guest_aquisition'] 	= ['required','numeric'];
		
		$rules['setting.tv_channel.*.no'] 					= ['required','string'];
		$rules['setting.tv_channel.*.name'] 				= ['required','string'];
		$rules['setting.tv_channel.*.category'] 			= ['required','string'];
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

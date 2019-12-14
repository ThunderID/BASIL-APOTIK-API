<?php

namespace Thunderlabid\POS\Observer;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\MessageBag;
use Validator;

use Thunderlabid\POS\Price;

class PriceObserver
{
	public function saving(Price $price)
	{
	}

	public function saved(Price $price)
	{
	}

	public function creating(Price $price)
	{
	}

	public function created(Price $price)
	{
	}

	public function updating(Price $price)
	{
		/*----------  Cannot edit price in the past  ----------*/
		$prev_active_at = \Carbon\Carbon::parse($price->getOriginal('active_at'));
		if ($prev_active_at->lt(now())) throw ValidationException::withMessages(['id' => 'immutable:PRICE_IN_PAST']);
	}

	public function updated(Price $price)
	{
	}

	public function deleting(Price $price)
	{
		/*----------  Cannot edit price in the past  ----------*/
		$prev_active_at = \Carbon\Carbon::parse($price->getOriginal('active_at'));
		if ($prev_active_at->lt(now())) throw ValidationException::withMessages(['id' => 'immutable:PRICE_IN_PAST']);
	}

	public function deleted(Price $price)
	{
	}

	public function restoring(Price $price)
	{
	}
	
	public function restored(Price $price)
	{
	}

	public function forceDeleting(Price $price)
	{
		/*----------  Cannot edit price in the past  ----------*/
		$prev_active_at = \Carbon\Carbon::parse($price->getOriginal('active_at'));
		if ($prev_active_at->lt(now())) throw ValidationException::withMessages(['id' => 'immutable:PRICE_IN_PAST']);
	}
	
	public function forceDeleted(Price $price)
	{
	}

	public function retrieved(Price $price)
	{
	}
}

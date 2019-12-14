<?php

namespace Thunderlabid\POS\Observer;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\MessageBag;
use Validator;

use Thunderlabid\POS\POSPoint;

class POSPointObserver
{
	public function saving(POSPoint $pos_point)
	{
	}

	public function saved(POSPoint $pos_point)
	{
	}

	public function creating(POSPoint $pos_point)
	{
	}

	public function created(POSPoint $pos_point)
	{
	}

	public function updating(POSPoint $pos_point)
	{
	}

	public function updated(POSPoint $pos_point)
	{
	}

	public function deleting(POSPoint $pos_point)
	{
		/*----------  Cannot delete if has invoices  ----------*/
		if ($pos_point->invoices()->count()) throw ValidationException::withMessages(['id' => 'immutable:HAS_INVOICES']);

		/*----------  Cannot delete if has products  ----------*/
		if ($pos_point->products()->count()) throw ValidationException::withMessages(['id' => 'immutable:HAS_PRODUCTS']);
		
	}

	public function deleted(POSPoint $pos_point)
	{
	}

	public function restoring(POSPoint $pos_point)
	{
	}
	
	public function restored(POSPoint $pos_point)
	{
	}

	public function forceDeleting(POSPoint $pos_point)
	{
		/*----------  Cannot delete if has invoices  ----------*/
		if ($pos_point->invoices()->count()) throw ValidationException::withMessages(['id' => 'immutable:HAS_INVOICES']);

		/*----------  Cannot delete if has products  ----------*/
		if ($pos_point->products()->count()) throw ValidationException::withMessages(['id' => 'immutable:HAS_PRODUCTS']);
		
	}
	
	public function forceDeleted(POSPoint $pos_point)
	{
	}

	public function retrieved(POSPoint $pos_point)
	{
	}
}

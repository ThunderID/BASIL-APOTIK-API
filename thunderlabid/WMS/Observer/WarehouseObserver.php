<?php

namespace Thunderlabid\WMS\Observer;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\MessageBag;
use Validator;

use Thunderlabid\WMS\Warehouse;

class WarehouseObserver
{
	public function saving(Warehouse $warehouse)
	{
	}

	public function saved(Warehouse $warehouse)
	{
	}

	public function creating(Warehouse $warehouse)
	{
	}

	public function created(Warehouse $warehouse)
	{
	}

	public function updating(Warehouse $warehouse)
	{
	}

	public function updated(Warehouse $warehouse)
	{
	}

	public function deleting(Warehouse $warehouse)
	{
		/*----------  Cannot delete if has StockCards  ----------*/
		if ($warehouse->StockCards()->count()) throw ValidationException::withMessages(['id' => 'immutable:HAS_StockCardS']);

		/*----------  Cannot delete if has products  ----------*/
		if ($warehouse->products()->count()) throw ValidationException::withMessages(['id' => 'immutable:HAS_PRODUCTS']);
		
	}

	public function deleted(Warehouse $warehouse)
	{
	}

	public function restoring(Warehouse $warehouse)
	{
	}
	
	public function restored(Warehouse $warehouse)
	{
	}

	public function forceDeleting(Warehouse $warehouse)
	{
		/*----------  Cannot delete if has StockCards  ----------*/
		if ($warehouse->StockCards()->count()) throw ValidationException::withMessages(['id' => 'immutable:HAS_StockCardS']);

		/*----------  Cannot delete if has products  ----------*/
		if ($warehouse->products()->count()) throw ValidationException::withMessages(['id' => 'immutable:HAS_PRODUCTS']);
		
	}
	
	public function forceDeleted(Warehouse $warehouse)
	{
	}

	public function retrieved(Warehouse $warehouse)
	{
	}
}

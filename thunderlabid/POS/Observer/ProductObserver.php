<?php

namespace Thunderlabid\POS\Observer;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\MessageBag;
use Validator;

use Thunderlabid\POS\Product;

class ProductObserver
{
	public function saving(Product $product)
	{
	}

	public function saved(Product $product)
	{
	}

	public function creating(Product $product)
	{
	}

	public function created(Product $product)
	{
	}

	public function updating(Product $product)
	{
	}

	public function updated(Product $product)
	{
	}

	public function deleting(Product $product)
	{
		/*----------  Cannot delete if already has price  ----------*/
		if ($product->prices()->count()) throw ValidationException::withMessages(['id' => 'immutable:HAS_PRICES']);
		
		
	}

	public function deleted(Product $product)
	{
	}

	public function restoring(Product $product)
	{
	}
	
	public function restored(Product $product)
	{
	}

	public function forceDeleting(Product $product)
	{
		/*----------  Cannot delete if already has price  ----------*/
		if ($product->prices()->count()) throw ValidationException::withMessages(['id' => 'immutable:HAS_PRICES']);
	}
	
	public function forceDeleted(Product $product)
	{
	}

	public function retrieved(Product $product)
	{
	}
}

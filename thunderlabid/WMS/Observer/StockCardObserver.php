<?php

namespace Thunderlabid\WMS\Observer;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\MessageBag;
use Validator;
use Arr;

use Thunderlabid\WMS\StockCard;
use Thunderlabid\WMS\Product;

class StockCardObserver
{
	public function saving(StockCard $stock_card) {
		/*----------  Check if Product Exist & Available  ----------*/
		$product = app()->make(Product::class)->findorfail($stock_card->product_id);
	}

	public function saved(StockCard $stock_card) {
	}

	public function creating(StockCard $stock_card) {
		
	}

	public function created(StockCard $stock_card)
	{
	}

	public function updating(StockCard $stock_card) {
		
	}

	public function updated(StockCard $stock_card) {
	}

	public function deleting(StockCard $stock_card) {
		throw ValidationException::withMessages(['id' => 'NOT_DELETABLE']);
	}

	public function deleted(StockCard $stock_card) {
	}

	public function restoring(StockCard $stock_card) {
	}
	
	public function restored(StockCard $stock_card) {
	}

	public function forceDeleting(StockCard $stock_card) {
		throw ValidationException::withMessages(['id' => 'NOT_DELETABLE']);
	}
	
	public function forceDeleted(StockCard $stock_card) {
	}

	public function retrieved(StockCard $stock_card) {
	}
}

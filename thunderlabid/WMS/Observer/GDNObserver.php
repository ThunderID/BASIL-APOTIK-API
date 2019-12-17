<?php

namespace Thunderlabid\WMS\Observer;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\MessageBag;
use Validator;
use Arr;

use Thunderlabid\WMS\GDN;
use Thunderlabid\WMS\Product;
use Thunderlabid\WMS\StockCard;

class GDNObserver
{
	public function saving(GDN $gdn) {
		/*----------  Check if Product Exist & Available  ----------*/
		$product_ids = Arr::pluck($gdn->lines, ['product_id']);
		$products = app()->make(Product::class)->whereIn('id', $product_ids)->get();

		$errors = [];
		$lines = $gdn->lines;
		foreach ($lines as $k => $line)
		{
			$product = $products->firstWhere('id', $line['product_id']); 
			if (!$product)
			{
				$errors["lines.$k.product_id"][] = 'exists';
			}
			// elseif (!$product->is_available)
			// {
			// 	$errors["lines.$k.product_id"][] = 'invalid:NOT_AVAILABLE';
			// }
			else
			{
				/*----------  Autofill Product Name, Price & Discount  ----------*/
				$lines[$k]['name']     = $product->name;
			}
		}
		$gdn->lines = $lines;
		if ($errors) throw ValidationException::withMessages($errors);

		if(is_null($gdn->no)){
			$gdn->no 	= $gdn->generateNo();
		}
	}

	public function saved(GDN $gdn) {
		// SIMPAN KE STOCKCARD
		$lines = $gdn->lines;
		foreach ($lines as $k => $line) {
			$stc 	= StockCard::where('product_id', $line['product_id'])->firstornew(['ref_id' => $gdn->id, 'ref_type' =>get_class($gdn)]);
			$stc->warehouse_id 	= $gdn['warehouse_id'];
			$stc->ref_id 		= $gdn['id'];
			$stc->ref_type 		= get_class($gdn);
			$stc->date 			= $gdn['date'];
			$stc->product_id 	= $line['product_id'];
			$stc->qty 			= $line['qty'] * -1;
			$stc->sku 			= $line['sku'];
			$stc->expired_at	= isset($line['expired_at']) ? $line['expired_at'] : null;
			$stc->save();
		}

		// HAPUS NOT LISTED ID
		$product_ids 	= array_column($lines, 'product_id');
		$stcs 			= StockCard::whereNotIn('product_id', $product_ids)->where('ref_id', $gdn->id)->where('ref_type', get_class($gdn))->delete();
	}

	public function creating(GDN $gdn) {
	}

	public function created(GDN $gdn)
	{
	}

	public function updating(GDN $gdn) {
	}

	public function updated(GDN $gdn) {
	}

	public function deleting(GDN $gdn) {
		// throw ValidationException::withMessages(['id' => 'NOT_DELETABLE']);

		/*----------  Cannot delete if already have settlement  ----------*/
		if ($gdn->stock_cards()->count())
		{
			throw ValidationException::withMessages(['id' => 'immutable:HAS_STOCKS']);
		}
		
	}

	public function deleted(GDN $gdn) {
		$stcs	= StockCard::where('ref_id', $gdn->id)->where('ref_type', get_class($gdn))->delete();
	}

	public function restoring(GDN $gdn) {
	}
	
	public function restored(GDN $gdn) {
	}

	public function forceDeleting(GDN $gdn) {
		// throw ValidationException::withMessages(['id' => 'NOT_DELETABLE']);

		/*----------  Cannot delete if already have settlement  ----------*/
		if ($gdn->stock_cards()->count())
		{
			throw ValidationException::withMessages(['id' => 'immutable:HAS_STOCKS']);
		}
	}
	
	public function forceDeleted(GDN $gdn) {
	}

	public function retrieved(GDN $gdn) {
	}
}

<?php

namespace Thunderlabid\WMS\Observer;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\MessageBag;
use Validator;
use Arr;

use Thunderlabid\WMS\GRN;
use Thunderlabid\WMS\Product;
use Thunderlabid\WMS\StockCard;

class GRNObserver
{
	public function saving(GRN $grn) {
		/*----------  Check if Product Exist & Available  ----------*/
		$product_ids = Arr::pluck($grn->lines, ['product_id']);
		$products = app()->make(Product::class)->whereIn('id', $product_ids)->get();

		$errors = [];
		$lines = $grn->lines;
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
		$grn->lines = $lines;
		if ($errors) throw ValidationException::withMessages($errors);

		if(is_null($grn->no)){
			$grn->no 	= $grn->generateNo();
		}
	}

	public function saved(GRN $grn) {
		// SIMPAN KE STOCKCARD
		$lines = $grn->lines;
		foreach ($lines as $k => $line) {
			$stc 	= StockCard::where('product_id', $line['product_id'])->firstornew(['ref_id' => $grn->id, 'ref_type' =>get_class($grn)]);
			$stc->warehouse_id 	= $grn['warehouse_id'];
			$stc->ref_id 		= $grn['id'];
			$stc->ref_type 		= get_class($grn);
			$stc->date 			= $grn['date'];
			$stc->product_id 	= $line['product_id'];
			$stc->qty 			= $line['qty'];
			$stc->sku 			= $line['sku'];
			$stc->expired_at	= isset($line['expired_at']) ? $line['expired_at'] : null;
			$stc->save();
		}

		// HAPUS NOT LISTED ID
		$product_ids 	= array_column($lines, 'product_id');
		$stcs 			= StockCard::whereNotIn('product_id', $product_ids)->where('ref_id', $grn->id)->where('ref_type', get_class($grn))->delete();
	}

	public function creating(GRN $grn) {
	}

	public function created(GRN $grn)
	{
	}

	public function updating(GRN $grn) {
	}

	public function updated(GRN $grn) {
	}

	public function deleting(GRN $grn) {
		// throw ValidationException::withMessages(['id' => 'NOT_DELETABLE']);

		/*----------  Cannot delete if already have settlement  ----------*/
		if ($grn->stock_cards()->count())
		{
			throw ValidationException::withMessages(['id' => 'immutable:HAS_STOCKS']);
		}
		
	}

	public function deleted(GRN $grn) {
		$stcs	= StockCard::where('ref_id', $grn->id)->where('ref_type', get_class($grn))->delete();
	}

	public function restoring(GRN $grn) {
	}
	
	public function restored(GRN $grn) {
	}

	public function forceDeleting(GRN $grn) {
		// throw ValidationException::withMessages(['id' => 'NOT_DELETABLE']);

		/*----------  Cannot delete if already have settlement  ----------*/
		if ($grn->stock_cards()->count())
		{
			throw ValidationException::withMessages(['id' => 'immutable:HAS_STOCKS']);
		}
	}
	
	public function forceDeleted(GRN $grn) {
	}

	public function retrieved(GRN $grn) {
	}
}

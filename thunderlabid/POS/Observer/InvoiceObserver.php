<?php

namespace Thunderlabid\POS\Observer;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\MessageBag;
use Validator;
use Arr;

use Thunderlabid\POS\Invoice;
use Thunderlabid\POS\Product;

class InvoiceObserver
{
	public function saving(Invoice $invoice)
	{
		/*----------  Check if Product Exist & Available  ----------*/
		$errors = [];
		$lines = $invoice->lines;
		foreach ($lines as $k => $line)
		{
			$product_ids = Arr::pluck($line['contains'], ['product_id']);
			$products = app()->make(\App\Product::class)->find($product_ids);
			foreach ($line['contains'] as $k2 => $contain){
				$product = $products->firstWhere('id', $contain['product_id']); 
				if (!$product)
				{
					$errors["lines.$k.contains.$k2.product_id"][] = 'exists';
				}
				// elseif (!$product->is_available)
				// {
				// 	$errors["lines.$k.contains.$k2.product_id"][] = 'invalid:NOT_AVAILABLE';
				// }
				elseif (!$product->price)
				{
					$errors["lines.$k.contains.$k2.product_id"][] = 'invalid:HAS_NO_PRICE';
				}
				else
				{
					/*----------  Autofill Product Name, Price & Discount  ----------*/
					$lines[$k]['contains'][$k2]['code']     = $product->code;
					$lines[$k]['contains'][$k2]['name']     = $product->name;
					$lines[$k]['contains'][$k2]['price']    = $product->price->price;
					// if($contain['discount'] < 0){
						$lines[$k]['contains'][$k2]['discount'] = $product->price->discount;
					// }else{
					// 	$lines[$k]['contains'][$k2]['discount'] = $contain['discount'];
					// }
				}
			}
		}
		$invoice->lines = $lines;

		if(!is_null($invoice->cancelled_at) && $invoice->settlements()->count()){
			$errors["id"][] = 'immutable:HAS_SETTLEMENTS';
		}
		if ($errors) throw ValidationException::withMessages($errors);
	}

	public function saved(Invoice $invoice)
	{
	}

	public function creating(Invoice $invoice)
	{
		/*----------  Discount < total invoice  ----------*/
		if ($invoice->getTotalInvoiceLine() < $invoice->discount)
		{
			throw ValidationException::withMessages(['discount' => 'lte:' . $invoice->getTotalInvoiceLine()]);
		}
	}

	public function created(Invoice $invoice)
	{
	}

	public function updating(Invoice $invoice)
	{
		/*----------  Discount < total invoice  ----------*/
		if ($invoice->getTotalInvoiceLine() < $invoice->discount)
		{
			throw ValidationException::withMessages(['discount' => 'lte:' . $invoice->getTotalInvoiceLine()]);
		}
	}

	public function updated(Invoice $invoice)
	{
	}

	public function deleting(Invoice $invoice)
	{
		throw ValidationException::withMessages(['id' => 'NOT_DELETABLE']);

		/*----------  Cannot delete if already have settlement  ----------*/
		if ($invoice->settlements()->count())
		{
			throw ValidationException::withMessages(['id' => 'immutable:HAS_SETTLEMENTS']);
		}
		
	}

	public function deleted(Invoice $invoice)
	{
	}

	public function restoring(Invoice $invoice)
	{
	}
	
	public function restored(Invoice $invoice)
	{
	}

	public function forceDeleting(Invoice $invoice)
	{
		throw ValidationException::withMessages(['id' => 'NOT_DELETABLE']);

		/*----------  Cannot delete if already have settlement  ----------*/
		if ($invoice->settlements()->wherenull('cancelled_at')->count())
		{
			throw ValidationException::withMessages(['id' => 'immutable:HAS_SETTLEMENTS']);
		}
	}
	
	public function forceDeleted(Invoice $invoice)
	{
	}

	public function retrieved(Invoice $invoice)
	{
	}

	public function voiding(Invoice $invoice)
	{
		if ($invoice->settlements()->count())
		{
			throw ValidationException::withMessages(['id' => 'immutable:HAS_SETTLEMENTS']);
		}
	}

	public function voided(Invoice $invoice)
	{
	}
}

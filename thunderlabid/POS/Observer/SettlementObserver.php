<?php

namespace Thunderlabid\POS\Observer;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\MessageBag;
use Validator;

use Thunderlabid\POS\Settlement;

class SettlementObserver
{
	public function saving(Settlement $settlement)
	{
	}

	public function saved(Settlement $settlement)
	{
	}

	public function creating(Settlement $settlement)
	{
	}

	public function created(Settlement $settlement)
	{
	}

	public function updating(Settlement $settlement)
	{
	}

	public function updated(Settlement $settlement)
	{
	}

	public function deleting(Settlement $settlement)
	{
		throw ValidationException::withMessages(['id' => 'immutable']);
	}

	public function deleted(Settlement $settlement)
	{
	}

	public function restoring(Settlement $settlement)
	{
	}
	
	public function restored(Settlement $settlement)
	{
	}

	public function forceDeleting(Settlement $settlement)
	{
		throw ValidationException::withMessages(['id' => 'immutable']);
	}
	
	public function forceDeleted(Settlement $settlement)
	{
	}

	public function retrieved(Settlement $settlement)
	{
	}
}

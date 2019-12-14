<?php

namespace Thunderlabid\Accounting\Observer;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\MessageBag;
use Validator;

use Thunderlabid\Accounting\JournalEntryLine;

class JournalEntryLineObserver extends Observer
{
	public function saving(JournalEntryLine $jel)
	{
		/*----------  Validate  ----------*/
		$this->errors->merge(Validator::make($jel->makeVisible($jel->getHidden())->toArray(), $jel->getRules())->errors());

		/*----------  Throw Exception  ----------*/
		$this->throw_exception();
	}

	public function saved(JournalEntryLine $jel)
	{
	}

	public function creating(JournalEntryLine $jel)
	{
	}

	public function created(JournalEntryLine $jel)
	{
	}

	public function updating(JournalEntryLine $jel)
	{
	}

	public function updated(JournalEntryLine $jel)
	{
	}

	public function deleting(JournalEntryLine $jel)
	{
	}

	public function deleted(JournalEntryLine $jel)
	{
	}

	public function restoring(JournalEntryLine $jel)
	{
	}
	
	public function restored(JournalEntryLine $jel)
	{
	}

	public function forceDeleting(JournalEntryLine $jel)
	{
	}
	
	public function forceDeleted(JournalEntryLine $jel)
	{
	}

	public function retrieved(JournalEntryLine $jel)
	{
	}
}

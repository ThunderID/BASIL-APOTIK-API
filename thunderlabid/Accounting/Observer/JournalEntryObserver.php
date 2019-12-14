<?php

namespace Thunderlabid\Accounting\Observer;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\MessageBag;
use Validator;

use Thunderlabid\Accounting\JournalEntry;

class JournalEntryObserver extends Observer
{
	public function saving(JournalEntry $je)
	{
		/*----------  Assign No & Date  ----------*/
		$je->autoSetNo();
		
		/*----------  Validate  ----------*/
		$this->errors->merge(Validator::make($je->makeVisible($je->getHidden())->toArray(), $je->getRules())->errors());

		/*----------  Balance  ----------*/
		$balance = 0;
		foreach ($je->lines as $k => $line)
		{
			if (isset($line['amount']))
			{
				$balance += $line['amount'];
			}
		}

		if ($balance != 0)
		{
			$this->errors->merge(['balance'	=> 'ne:0']);
		}

		/*----------  Throw Exception  ----------*/
		$this->throw_exception();
	}

	public function saved(JournalEntry $je)
	{
	}

	public function creating(JournalEntry $je)
	{
	}

	public function created(JournalEntry $je)
	{
		/*----------  AutoPost To JournalEntryLine  ----------*/
		\Thunderlabid\Accounting\Job\JournalEntry\AutoPostToJournalEntryLine::dispatch($je);
	}

	public function updating(JournalEntry $je)
	{
		/*----------  Cannot Edit JE - use void ----------*/
		// $this->errors->merge(['id' => 'immutable:cannot edit Journal Entry']);
		
		/*----------  Throw Exception  ----------*/
		// $this->throw_exception();
	}

	public function updated(JournalEntry $je)
	{
	}

	public function deleting(JournalEntry $je)
	{
		/*----------  Cannot Edit JE - use void ----------*/
		// $this->errors->merge(['id' => 'immutable:cannot edit Journal Entry']);
		
	}

	public function deleted(JournalEntry $je)
	{
	}

	public function restoring(JournalEntry $je)
	{
	}
	
	public function restored(JournalEntry $je)
	{
	}

	public function forceDeleting(JournalEntry $je)
	{
		/*----------  Cannot Edit JE - use void ----------*/
		// $this->errors->merge(['id' => 'immutable:cannot edit Journal Entry']);
		
	}
	
	public function forceDeleted(JournalEntry $je)
	{
	}

	public function retrieved(JournalEntry $je)
	{
	}
}

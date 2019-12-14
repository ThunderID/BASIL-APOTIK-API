<?php

namespace Thunderlabid\Accounting\Observer;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\MessageBag;
use Validator;

use Thunderlabid\Accounting\COA;

class COAObserver extends Observer
{
	public function saving(COA $coa)
	{
		/*----------  Validate  ----------*/
		$this->errors->merge(Validator::make($coa->makeVisible($coa->getHidden())->toArray(), $coa->getRules())->errors());

		/*----------  Throw Exception  ----------*/
		$this->throw_exception();
	}

	public function saved(COA $coa)
	{
	}

	public function creating(COA $coa)
	{
	}

	public function created(COA $coa)
	{
	}

	public function updating(COA $coa)
	{
		/*----------  Check if Circular  ----------*/
		if ($coa->id)
		{
			$parent_ids = [];
			$tmp = $coa;
			$parent_ids[] = $tmp->id;
			while ($tmp->parent_id) {
				if (in_array($tmp->parent_id, $parent_ids))
				{
					$this->errors->merge(['parent_id' => 'circular']);
					break;
				}
				$tmp = $tmp->parent;
				$parent_ids[] = $tmp->id;
			}
		}

		/*----------  Cannot Change Type  ----------*/
		if ($coa->getOriginal('type') != $coa->type)
		{
			$this->errors->merge(['type' => 'immutable']);
		}

		/*----------  Throw Exception  ----------*/
		$this->throw_exception();
	}

	public function updated(COA $coa)
	{
	}

	public function deleting(COA $coa)
	{
		/*----------  Has No Children  ----------*/
		if ($coa->subaccounts()->count())
		{
			$this->errors->merge(['id' => 'hasSubAccount']);
		}

		/*----------  Has No Subsidiaries  ----------*/
		if ($coa->subsidiaries()->count())
		{
			$this->errors->merge(['id' => 'hasSubsidiaries']);
		}

		/*----------  Has No JournalEntry  ----------*/
		// if ($coa->journal_entry_lines()->count())
		// {
		// 	$this->errors->merge(['id' => 'hasJournalEntry']);
		// }

		/*----------  Throw Exception  ----------*/
		$this->throw_exception();
	}

	public function deleted(COA $coa)
	{
	}

	public function restoring(COA $coa)
	{
	}
	
	public function restored(COA $coa)
	{
	}

	public function forceDeleting(COA $coa)
	{
	}
	
	public function forceDeleted(COA $coa)
	{
	}

	public function retrieved(COA $coa)
	{
	}
}

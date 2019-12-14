<?php

namespace Thunderlabid\Accounting\Observer;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\MessageBag;
use Validator;

use Thunderlabid\Accounting\SubsidiaryCOA;

class SubsidiaryCOAObserver extends Observer
{
	public function saving(SubsidiaryCOA $subsidiary_coa)
	{
		/*----------  Validate  ----------*/
		$this->errors->merge(Validator::make($subsidiary_coa->makeVisible($subsidiary_coa->getHidden())->toArray(), $subsidiary_coa->getRules())->errors());

		/*----------  COA - cannot save to COA that !hasSubsidiary  ----------*/
		if ($subsidiary_coa->coa && !$subsidiary_coa->coa->has_subsidiary)
		{
			$this->errors->merge(['coa_id'	=> 'invalid:cannot_have_subsidiary']);
		}

		/*----------  Throw Exception  ----------*/
		$this->throw_exception();
	}

	public function saved(SubsidiaryCOA $subsidiary_coa)
	{
	}

	public function creating(SubsidiaryCOA $subsidiary_coa)
	{
	}

	public function created(SubsidiaryCOA $subsidiary_coa)
	{
	}

	public function updating(SubsidiaryCOA $subsidiary_coa)
	{
	}

	public function updated(SubsidiaryCOA $subsidiary_coa)
	{
	}

	public function deleting(SubsidiaryCOA $subsidiary_coa)
	{
		/*----------  Cannot delete if has journal entry  ----------*/
		if ($subsidiary_coa->journal_entries()->count())
		{
			$this->errors->merge(['id'	=> 'invalid:have_journal_entries']);
		}

		/*----------  Throw Exception  ----------*/
		$this->throw_exception();
	}

	public function deleted(SubsidiaryCOA $subsidiary_coa)
	{
	}

	public function restoring(SubsidiaryCOA $subsidiary_coa)
	{
	}
	
	public function restored(SubsidiaryCOA $subsidiary_coa)
	{
	}

	public function forceDeleting(SubsidiaryCOA $subsidiary_coa)
	{
		/*----------  Cannot delete if has journal entry  ----------*/
		if ($subsidiary_coa->journal_entries()->count())
		{
			$this->errors->merge(['id'	=> 'invalid:have_journal_entries']);
		}

		/*----------  Throw Exception  ----------*/
		$this->throw_exception();
	}
	
	public function forceDeleted(SubsidiaryCOA $subsidiary_coa)
	{
	}

	public function retrieved(SubsidiaryCOA $subsidiary_coa)
	{
	}
}

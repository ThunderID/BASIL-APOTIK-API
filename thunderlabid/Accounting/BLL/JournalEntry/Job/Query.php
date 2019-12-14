<?php

namespace Thunderlabid\Accounting\BLL\JournalEntry\Job;

/*=================================
=            FRAMEWORK            =
=================================*/
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\Builder;
use Validator;
use DB;
/*=====  End of FRAMEWORK  ======*/

/*==============================
=            DOMAIN            =
==============================*/
// Event
use Thunderlabid\Accounting\BLL\JournalEntry\Event\Querying;
use Thunderlabid\Accounting\BLL\JournalEntry\Event\Queried;

// Data
use Thunderlabid\Accounting\JournalEntry;
/*=====  End of DOMAIN  ======*/

class Query 
{
	public function __construct(Array $queries = [])
	{
		parent::__construct($queries, ['name', 'no', 'date'], $mode);
	}

	protected function buildQuery(Builder $q, Object $queries)
	{
		/*====================================
		=            Parent Query            =
		====================================*/
		$q = parent::buildQuery($q, $queries);
		/*=====  End of Parent Query  ======*/
		

		/*========================================
		=            Additional Query            =
		========================================*/
		foreach ($this->queries as $field => $v)    
		{
			if (isset($v) && !is_null($v))
			{
				switch (strtolower($field))
				{
					/*----------  Current Model  ----------*/
					case 'no': $q = $q->no($v); break;

					case 'date_gt': $q = $q->where('date', '>', $v); break;
					case 'date_gte': $q = $q->where('date', '>=', $v); break;
					case 'date_lt': $q = $q->where('date', '<', $v); break;
					case 'date_lte': $q = $q->where('date', '<=', $v); break;

					case 'status': $q = $q->status($v);break;
				}
			}
		}
		/*=====  End of Additional Query  ======*/
		

		/*==============================
		=            RETURN            =
		==============================*/
		return $q;
		/*=====  End of RETURN  ======*/
	}

	public function handle(JournalEntry $model, Querying $preEvent, Queried $journal_entriestEvent)
	{
		return parent::handle($model, $preEvent, $journal_entriestEvent);
	}
}

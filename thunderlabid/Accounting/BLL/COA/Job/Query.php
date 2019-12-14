<?php

namespace Thunderlabid\Accounting\BLL\COA\Job;

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
use Thunderlabid\Accounting\BLL\COA\Event\Querying;
use Thunderlabid\Accounting\BLL\COA\Event\Queried;

// Data
use Thunderlabid\Accounting\COA;
/*=====  End of DOMAIN  ======*/


class Query 
{
	public function __construct(Array $queries = [])
	{
		parent::__construct($queries, ['name', 'is_principle', 'is_distributor','created_at', 'updated_at'], $mode);
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
					case 'name': $q = $q->name($v); break;

					/*----------  Relations  ----------*/
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

	public function handle(COA $model, Querying $preEvent, Queried $journal_entriestEvent)
	{
		return parent::handle($model, $preEvent, $journal_entriestEvent);
	}
}

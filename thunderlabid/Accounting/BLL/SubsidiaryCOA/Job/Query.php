<?php

namespace Thunderlabid\Accounting\BLL\SubsidiaryCOA\Job;

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
use Thunderlabid\Accounting\BLL\SubsidiaryCOA\Event\Querying;
use Thunderlabid\Accounting\BLL\SubsidiaryCOA\Event\Queried;

// Data
use Thunderlabid\Accounting\SubsidiaryCOA;
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
					case 'is_principle': $q = $q->is_principle($v); break;
					case 'is_distributor': $q = $q->is_distributor($v); break;
					case 'is_reseller': $q = $q->is_reseller($v); break;

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

	public function handle(SubsidiaryCOA $model, Querying $preEvent, Queried $journal_entriestEvent)
	{
		return parent::handle($model, $preEvent, $journal_entriestEvent);
	}
}

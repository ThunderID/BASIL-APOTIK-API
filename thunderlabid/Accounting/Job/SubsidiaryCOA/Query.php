<?php

namespace Thunderlabid\Accounting\Job\SubsidiaryCOA;

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
use Arr;
/*=====  End of FRAMEWORK  ======*/

/*==============================
=            DOMAIN            =
==============================*/
use Thunderlabid\Accounting\Traits\Job\{IDQueryTrait, TimestampQueryTrait, SoftDeleteQueryTrait};
use Thunderlabid\Accounting\SubsidiaryCOA;
/*=====  End of DOMAIN  ======*/


class Query
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	use IDQueryTrait, TimestampQueryTrait, SoftDeleteQueryTrait;

	const PER_PAGE = 25;
	const MAX_PER_PAGE = 100;

	public function __construct(Array $queries = [], Bool $is_paginate = true)
	{
		$this->queries = $queries;
		$this->is_paginate = $is_paginate;
	}

	protected function buildQuery(Builder $q)
	{
		$q = $this->buildIDQuery($q, $this->queries);
		$q = $this->buildTimestampQuery($q, $this->queries);
		$q = $this->buildSoftDeleteQuery($q, $this->queries);

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
					case 'coa_id': $q = $q->coaId($v); break;
					case 'type': $q = $q->type($v); break;
					case 'search': $q = $q->search($v); break;
					case 'code': $q = $q->code($v); break;
					case 'name': $q = $q->name($v); break;
					case 'isArchived': $q = $q->isArchived($v); break;
					case 'isLocked': $q = $q->isLocked($v); break;
					case 'hasSubsidiary': $q = $q->hasSubsidiary($v); break;

					/*----------  Relationships  ----------*/
					
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

	public function handle(SubsidiaryCOA $model)
	{
		$q = $model->newQuery();
		$q = $this->buildQuery($q);
		if ($this->is_paginate)
		{
			return $q->paginate(
				isset($this->queries['limit']) && $this->queries['limit'] > 0 ? max(0, min($this->queries['limit'], Static::MAX_PER_PAGE)) : Static::PER_PAGE,
				['*'],
				'page',
				isset($this->queries['page']) && $this->queries['page'] > 0 ? $this->queries['page'] : 1
			);
		}
		else
		{
			return $q->get();
		}
	}
}

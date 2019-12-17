<?php

namespace Thunderlabid\WMS\Job\StockCard;

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
use Thunderlabid\WMS\Traits\Job\{IDQueryTrait, TimestampQueryTrait, SoftDeleteQueryTrait, OrderByQueryTrait};
use Thunderlabid\WMS\StockCard;
/*=====  End of DOMAIN  ======*/


class Query
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	use IDQueryTrait, TimestampQueryTrait, SoftDeleteQueryTrait, OrderByQueryTrait;

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
		$q = $this->buildOrderByQuery($q, $this->queries);

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
					case 'warehouse_id': $q = $q->where('warehouse_id', $v); break;
					case 'product_id': $q = $q->where('product_id', $v); break;
					case 'date_gt': $q      = $q->dateGt($v); break;
					case 'date_gte': $q     = $q->dateGte($v); break;
					case 'date_lt': $q      = $q->dateLt($v); break;
					case 'date_lte': $q     = $q->dateLte($v); break;
					case 'product_name': $q = $q->wherehas('product', function($q2)use($v){$q2->name($v);}); break;
					case 'group_by_product': 
						$q	= $q->selectraw('warehouse_id')
							->selectraw('product_id')
							->selectraw('expired_at')
							->selectraw('sum(qty) as qty')
							->selectraw('max(date) as date')
							->selectraw('max(created_at) as created_at')
							->selectraw('max(updated_at) as updated_at')
							->groupby('warehouse_id')
							->groupby('product_id')
							->groupby('expired_at')
							; 
					break;
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

	public function handle(StockCard $model)
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

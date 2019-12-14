<?php

namespace Thunderlabid\POS\Traits\Job;

use Illuminate\Database\Eloquent\Builder;

trait OrderByQueryTrait {

	protected function buildOrderByQuery(Builder $q, Array $queries)
	{
		$desc 	= 'desc';
		foreach ($queries as $field => $v)    
		{
			if (isset($v) && !is_null($v))
			{
				switch (strtolower($field)) {
					case 'order_desc':
						if(!$v){
							$desc 	= 'asc';
						}
					break;
					case 'order_by':
						$q 	= $q->orderby($v, $desc);
					break;
				}
			}
		}

		return $q;
	}
}
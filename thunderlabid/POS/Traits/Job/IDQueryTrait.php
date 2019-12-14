<?php

namespace Thunderlabid\POS\Traits\Job;

use Illuminate\Database\Eloquent\Builder;

trait IDQueryTrait {

	protected function buildIDQuery(Builder $q, Array $queries)
	{
		foreach ($queries as $field => $v)    
		{
			if (isset($v) && !is_null($v))
			{
				switch (strtolower($field)) {
					case 'id':                $q = $q->whereIn('id', is_array($v) ? $v : [$v]); break;
					case 'except_id':         $q = $q->whereNotIn('id', is_array($v) ? $v : [$v]); break;
				}
			}
		}

		return $q;
	}

}
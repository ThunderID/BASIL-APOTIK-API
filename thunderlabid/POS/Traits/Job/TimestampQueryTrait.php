<?php

namespace Thunderlabid\POS\Traits\Job;

use Illuminate\Database\Eloquent\Builder;


trait TimestampQueryTrait {

	protected function buildTimestampQuery(Builder $q, Array $queries)
	{
		foreach ($queries as $field => $v)    
		{
			if (isset($v) && !is_null($v))
			{
				switch (strtolower($field)) {
					case 'id':                $q = $q->whereIn('id', is_array($v) ? $v : [$v]); break;
					case 'except_id':         $q = $q->whereNotIn('id', is_array($v) ? $v : [$v]); break;

					/*----------  Timestamps  ----------*/
					case 'created_at_gt':       $q = $q->where('created_at', '>', $v); break;
					case 'created_at_gte':      $q = $q->where('created_at', '>=', $v); break;
					case 'created_at_lt':       $q = $q->where('created_at', '<', $v); break;
					case 'created_at_lte':      $q = $q->where('created_at', '<=', $v); break;

					case 'updated_at_gt':       $q = $q->where('updated_at', '>', $v); break;
					case 'updated_at_gte':      $q = $q->where('updated_at', '>=', $v); break;
					case 'updated_at_lt':       $q = $q->where('updated_at', '<', $v); break;
					case 'updated_at_lte':      $q = $q->where('updated_at', '<=', $v); break;
				}
			}
		}

		return $q;
	}

}
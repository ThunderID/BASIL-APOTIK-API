<?php

namespace Thunderlabid\WMS\Traits\Job;

use Illuminate\Database\Eloquent\Builder;


trait SoftDeleteQueryTrait {

	protected function buildSoftDeleteQuery(Builder $q, Array $queries)
	{
		foreach ($queries as $field => $v)    
		{
			if (isset($v) && !is_null($v))
			{
				switch (strtolower($field)) {
					case 'with_deleted':        $q = $q->withTrashed(); break;
					case 'deleted_only':        $q = $q->onlyTrashed(); break;
					case 'deleted_at_gt':       $q = $q->where('deleted_at', '>', $v); break;
					case 'deleted_at_gte':      $q = $q->where('deleted_at', '>=', $v); break;
					case 'deleted_at_lt':       $q = $q->where('deleted_at', '<', $v); break;
					case 'deleted_at_lte':      $q = $q->where('deleted_at', '<=', $v); break;
				}
			}
		}

		return $q;
	}

}
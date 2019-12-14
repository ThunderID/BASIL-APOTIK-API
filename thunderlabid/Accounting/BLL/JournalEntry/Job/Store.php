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
use Thunderlabid\Accounting\BLL\JournalEntry\Event\CreatingOrUpdating;
use Thunderlabid\Accounting\BLL\JournalEntry\Event\CreatedOrUpdated;

// Data
use Thunderlabid\Accounting\JournalEntry;
/*=====  End of DOMAIN  ======*/


class Store extends \Thunderlabid\Libraries\Pattern\Job\StoreWithHasRelation
{
	public function __construct(Int $id = null, Array $relation_names = [], Array $attr = [])
	{
		parent::__construct($id, $relation_names, $attr);
	}
}

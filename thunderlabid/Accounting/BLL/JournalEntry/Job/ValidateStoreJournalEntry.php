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

/*============================
=            DATA            =
============================*/
use Thunderlabid\Accounting\JournalEntry;


/*=====  End of DATA  ======*/


class ValidateStoreJournalEntry extends \Thunderlabid\Libraries\Pattern\Job\ValidateStoreWithHasRelation
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
}

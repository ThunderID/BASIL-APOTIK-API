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

/*============================
=            DATA            =
============================*/
use Thunderlabid\Accounting\SubsidiaryCOA;


/*=====  End of DATA  ======*/


class ValidateStoreSubsidiaryCOA extends \Thunderlabid\Libraries\Pattern\Job\ValidateStoreWithHasRelation
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
}

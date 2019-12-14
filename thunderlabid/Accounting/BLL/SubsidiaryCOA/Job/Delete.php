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
use Thunderlabid\Accounting\BLL\SubsidiaryCOA\Event\Deleting;
use Thunderlabid\Accounting\BLL\SubsidiaryCOA\Event\Deleted;

// Data
use Thunderlabid\Accounting\SubsidiaryCOA;
/*=====  End of DOMAIN  ======*/


class Delete extends \Thunderlabid\Libraries\Pattern\Job\Delete
{
  public function __construct(Int $id)
  {
    parent::__construct($id);
  }
}

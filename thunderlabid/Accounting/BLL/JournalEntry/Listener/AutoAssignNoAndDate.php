<?php

namespace Thunderlabid\Accounting\BLL\JournalEntry\Listener;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Support\MessageBag;
use Hash;
use Validator;

/*============================
=            DATA            =
============================*/
/*=====  End of DATA  ======*/

/*==============================
=            DOMAIN            =
==============================*/
// Event
use Thunderlabid\Accounting\BLL\JournalEntry\Event\Generated;
// Job
use Thunderlabid\Accounting\BLL\JournalEntry\Job\AssignNoAndDate;
/*=====  End of DOMAIN  ======*/


class AutoAssignNoAndDate
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Generated $event)
    {
        AssignNoAndDate::dispatchNow($event->data);
    }
}

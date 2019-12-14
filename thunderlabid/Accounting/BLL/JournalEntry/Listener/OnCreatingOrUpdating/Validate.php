<?php

namespace Thunderlabid\Accounting\BLL\JournalEntry\Listener\OnCreatingOrUpdating;

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
use Thunderlabid\Accounting\BLL\JournalEntry\Event\CreatingOrUpdating;

// Validate
use Thunderlabid\Accounting\BLL\JournalEntry\Job\ValidateStoreJournalEntry;
/*=====  End of DOMAIN  ======*/


class Validate
{
    public function handle(CreatingOrUpdating $event)
    {
    	ValidateStoreJournalEntry::dispatchNow($event->data, (array) $event->attr);
    }
}

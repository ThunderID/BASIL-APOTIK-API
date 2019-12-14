de<?php

namespace Thunderlabid\Accounting\BLL\JournalEntry\Listener\Validator;

/*=================================
=            FRAMEWORK            =
=================================*/
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Support\MessageBag;
use Validator;
use DB;
/*=====  End of FRAMEWORK  ======*/

/*============================
=            DATA            =
============================*/
use Thunderlabid\Accounting\JournalEntry;
use Thunderlabid\Accounting\Status;
/*=====  End of DATA  ======*/

/*==============================
=            DOMAIN            =
==============================*/
use Thunderlabid\Accounting\BLL\JournalEntry\Event\CreatingOrUpdating;
use Thunderlabid\Accounting\BLL\JournalEntry\Event\ChangingStatus;
/*=====  End of DOMAIN  ======*/


class ValidateEditable
{
	public function __construct()
	{
	}

	public function handle($event)
	{
		if ($event->data && $event->data->id)
		{
			throw ValidationException::withMessages(['id' => 'NotEditable']);
		}
	}
}

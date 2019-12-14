<?php

namespace App\GraphQL\Mutation\Accounting\JournalEntry;

/*==============================
=            DOMAIN            =
==============================*/
use Thunderlabid\Accounting\GraphQL\JournalEntry\Mutation\Cancel as Mutation;
/*=====  End of DOMAIN  ======*/
use Auth;
use Thunderlabid\Accounting\JournalEntry;

class Cancel extends Mutation
{
	public function authorize(array $args)
	{
        return Auth::user() && Auth::user()->can('delete', JournalEntry::findorfail($args['id']));
	}
}
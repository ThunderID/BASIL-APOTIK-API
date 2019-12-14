<?php

namespace App\GraphQL\Mutation\Accounting\JournalEntry;

/*==============================
=            DOMAIN            =
==============================*/
use Thunderlabid\Accounting\GraphQL\JournalEntry\Mutation\Store as Mutation;
/*=====  End of DOMAIN  ======*/
use Auth;
use Thunderlabid\Accounting\JournalEntry;

class Store extends Mutation
{
	public function authorize(array $args)
	{
        return Auth::user() && Auth::user()->can(
                                    isset($args['id']) ? 'update' : 'create', 
                                    isset($args['id']) ? JournalEntry::find($args['id']) : app()->make(JournalEntry::class)->fill($args)
                                );
	}
}
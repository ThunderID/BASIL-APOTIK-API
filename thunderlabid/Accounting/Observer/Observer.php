<?php

namespace Thunderlabid\Accounting\Observer;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\MessageBag;
use Validator;

abstract class Observer
{
	function __construct()
	{
		$this->errors = new MessageBag;
	}

	protected function throw_exception()
	{
		if ($this->errors->keys())
		{
			throw ValidationException::withMessages($this->errors->toArray());
		}
	}
}

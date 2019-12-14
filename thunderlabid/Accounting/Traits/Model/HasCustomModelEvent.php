<?php

namespace Thunderlabid\Accounting\Traits\Model;

trait HasCustomModelEvent {

	public function fire($event)
	{
		$this->fireModelEvent($event, false);
	}
	
}
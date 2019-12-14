<?php

namespace Thunderlabid\POS\Traits\Model;

trait HasCustomModelEvent {

	public function fire($event)
	{
		$this->fireModelEvent($event, false);
	}
	
}
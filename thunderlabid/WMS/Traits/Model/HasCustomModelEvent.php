<?php

namespace Thunderlabid\WMS\Traits\Model;

trait HasCustomModelEvent {

	public function fire($event)
	{
		$this->fireModelEvent($event, false);
	}
	
}
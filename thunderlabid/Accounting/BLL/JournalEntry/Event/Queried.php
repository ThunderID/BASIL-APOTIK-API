<?php

namespace Thunderlabid\Accounting\BLL\JournalEntry\Event;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use Illuminate\Database\Eloquent\Model;

class Queried extends \Thunderlabid\Libraries\Pattern\Event\Queried
{
}

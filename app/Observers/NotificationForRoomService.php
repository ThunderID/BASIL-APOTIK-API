<?php

namespace App\Observers;

use Illuminate\Validation\ValidationException;
use DB;

use \App\Models\Record\RoomService;
use \App\Events\RequestRoomService;

class NotificationForRoomService
{
    //
    public function created(RoomService $rs)
    {
        event(new RequestRoomService($rs));
    }
}

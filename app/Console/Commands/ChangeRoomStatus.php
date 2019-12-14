<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Room;
use App\Models\HK\RoomStatus;

class ChangeRoomStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'room:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ganti status ruangan tiap tengah malam';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $ids    = config()->get('automation.status.org_ids');
        //GANTI OCCUPIED CLEAN KE OCCUPIED DIRTY
        foreach ($ids as $org_id) {
            $rooms    = Room::SearchByStatus([RoomStatus::OCCUPIED_CLEAN])->where('org_id', $org_id)->get();
            foreach ($rooms as $v) {
                RoomStatus::create(['room_id' => $v['id'], 'status' => RoomStatus::OCCUPIED_DIRTY, 'due_to_next_status' => $v->status->due_to_next_status]);
            }

            //GANTI VACANT CLEAN KE VACANT DIRTY
            $rooms    = Room::SearchByStatus([RoomStatus::VACANT_CLEAN])->where('org_id', $org_id)->get();
            foreach ($rooms as $v) {
                RoomStatus::create(['room_id' => $v['id'], 'status' => RoomStatus::VACANT_DIRTY, 'due_to_next_status' => $v->status->due_to_next_status]);
            }

            //GANTI VACANT READY KE VACANT CLEAN
            $rooms    = Room::SearchByStatus([RoomStatus::VACANT_READY])->where('org_id', $org_id)->get();
            foreach ($rooms as $v) {
                RoomStatus::create(['room_id' => $v['id'], 'status' => RoomStatus::VACANT_CLEAN, 'due_to_next_status' => $v->status->due_to_next_status]);
            }

            //UPDATED OCCUPIED DIRTY FOR NEXT ROW
            $rooms    = Room::SearchByStatus([RoomStatus::OCCUPIED_DIRTY])->where('org_id', $org_id)->get();
            foreach ($rooms as $v) {
                RoomStatus::create(['room_id' => $v['id'], 'status' => RoomStatus::OCCUPIED_DIRTY, 'due_to_next_status' => $v->status->due_to_next_status]);
            }
        }
    }
}

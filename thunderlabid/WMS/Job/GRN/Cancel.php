<?php

namespace Thunderlabid\WMS\Job\GRN;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use DB;

use Thunderlabid\WMS\GRN;

class Cancel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Int $id = null)
    {
        $this->id   = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(GRN $model)
    {
        return DB::transaction(function() use ($model) {

            $data = $model->findorfail($this->id);
            $data->cancel();

            return true;

        });
    }
}

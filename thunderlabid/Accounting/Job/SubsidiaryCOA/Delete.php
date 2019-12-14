<?php

namespace Thunderlabid\Accounting\Job\SubsidiaryCOA;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use DB;

use Thunderlabid\Accounting\SubsidiaryCOA;

class Delete implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Int $id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(SubsidiaryCOA $model)
    {
        return DB::transaction(function() use ($model) {
            
            $data = $model->findorfail($this->id);
            return $data->delete();

        });
    }
}

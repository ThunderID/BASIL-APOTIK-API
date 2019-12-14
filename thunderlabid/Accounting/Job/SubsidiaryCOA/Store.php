<?php

namespace Thunderlabid\Accounting\Job\SubsidiaryCOA;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use DB;

use Thunderlabid\Accounting\SubsidiaryCOA;

class Store implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id;
    protected $attr;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Int $id = null, Array $attr = [])
    {
        $this->id   = $id;
        $this->attr = $attr;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(SubsidiaryCOA $model)
    {
        return DB::transaction(function() use ($model) {
            if ($this->id)
            {
                $data = $model->findorfail($this->id);
            }
            else
            {
                $data = new $model;
            }

            $data->fill($this->attr);
            $data->save();

            return $data;
        });
    }
}

<?php

namespace Thunderlabid\POS\Job\Product\Price;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use DB;

use Thunderlabid\POS\Product;

class Delete implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id;
    protected $price_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Int $id, Int $price_id)
    {
        $this->id       = $id;
        $this->price_id = $price_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Product $model)
    {
        return DB::transaction(function() use ($model) {
            $data = $model->findorfail($this->id);
            return $data->prices()->findorfail($this->price_id)->delete();
        });
    }
}

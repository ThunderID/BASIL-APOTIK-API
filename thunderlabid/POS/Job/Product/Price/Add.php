<?php

namespace Thunderlabid\POS\Job\Product\Price;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use DB;

use Thunderlabid\POS\Product;

class Add implements ShouldQueue
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
    public function handle(Product $model)
    {
        return DB::transaction(function() use ($model) {
            $data = $model->findorfail($this->id);
            $price = $data->prices()->create($this->attr);

            return $price;
        });
    }
}

<?php

namespace Thunderlabid\Accounting\Job\JournalEntry;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use DB;

use Thunderlabid\Accounting\JournalEntry;
use Thunderlabid\Accounting\Supplier;

use Validator;

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
    public function handle(JournalEntry $model)
    {
        return DB::transaction(function() use ($model) {

            if ($this->id)
            {
                $data = app()->make(JournalEntry::class)->findorfail($this->id);
            }
            else
            {
                $data = app()->make(JournalEntry::class);
            }

            $data->fill($this->attr);
            $data->save();

            return $data;
            
        });
    }
}

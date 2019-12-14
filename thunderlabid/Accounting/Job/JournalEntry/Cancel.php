<?php

namespace Thunderlabid\Accounting\Job\JournalEntry;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use DB;

use Thunderlabid\Accounting\JournalEntry;

class Cancel implements ShouldQueue
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
    public function handle(JournalEntry $model)
    {
        return DB::transaction(function() use ($model) {
            
            $journal_entry = $model->findorfail($this->id);
            $journal_entry->void_at = now();
            $journal_entry->save();

            return $journal_entry;

        });
    }
}

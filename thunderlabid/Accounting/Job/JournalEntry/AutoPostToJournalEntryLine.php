<?php

namespace Thunderlabid\Accounting\Job\JournalEntry;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use DB;

use Thunderlabid\Accounting\JournalEntry;
use Thunderlabid\Accounting\JournalEntryLine;
use Thunderlabid\Accounting\Supplier;

use Thunderlabid\Accounting\Job\JournalEntry\Store as StoreJELine;

use Validator;

class AutoPostToJournalEntryLine implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $je;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(JournalEntry $je)
    {
        $this->je   = $je;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return DB::transaction(function() {

            foreach ($this->je->lines as $line)
            {
                JournalEntryLine::create([
                    'journal_entry_id'  => $this->je->id,
                    'coa_id'            => $line['coa_id'],
                    'subsidiary_coa_id' => $line['subsidiary_coa_id'],
                    'amount'            => $line['amount'],
                ]);
            }
            
        });
    }
}

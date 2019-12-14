<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Nexmo;

class SendSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $to;
    protected $text;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(String $to, String $text)
    {
        //
        $this->to   = $to;
        $this->text = $text;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        Nexmo::message()->send([
            'to'   => $this->to,
            'from' => config('nextmo.from') ? config('nextmo.from') : env('APP_NAME'),
            'text' => $this->text
        ]);
    }
}

<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Artisan;

class Threads implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $thread_id;
    public function __construct($thread_id)
    {
        $this->thread_id = $thread_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
         //Artisan::call('run:SmsThread', ['tid' => $this->thread_id]);
         \Illuminate\Support\Facades\Log::ibnfo("running thread = ".$this->thread_id);
    }
}

<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Mail\Mailer;
use App\User;
use Mail;
use Log;
use App\Cron_jobs;
use Artisan;

class RunCron implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $id;

    public function __construct($id) {
        $this->id = $id;
        //die();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $cronCommand = Cron_jobs::where('id', $this->id)->get()->first();
        Artisan::call($cronCommand->command);
    }
}

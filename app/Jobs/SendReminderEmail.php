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

class SendReminderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user) {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer) {
        //print_r($user);
        //die();
        //sleep(60);
        $user = User::findOrFail(36);
        for ($i = 1; $i <= 5; $i++) {
            sleep(60);
            sendSimpleEmail('aziz.hh01@gmail.com', 'ranaaazeem2008@gmail.com', 'aziz', "subject 60 sec", 'message ' . $i);
        }
    }
}

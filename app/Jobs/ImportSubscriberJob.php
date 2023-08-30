<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;


class ImportSubscriberJob implements ShouldQueue {

   use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    protected $import_id;
    public function __construct($import_id) {
        $this->import_id = $import_id;
    }

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function handle() {
        set_time_limit(0);
        Artisan::call('run:ImportSubscribers', ['id' => $this->import_id]);
    }

}

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


class ExportSubscriberJob implements ShouldQueue {

   use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    protected $export_id;
    public function __construct($export_id) {
        $this->export_id = $export_id;
    }

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function handle() {
        set_time_limit(0); die('id  = '.$this->export_id);
        Artisan::call('run:ExportSubscribers', ['id' => $this->export_id]);
    }

}

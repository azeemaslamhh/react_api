<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\prepairCampaigns;

class deleteClient implements ShouldQueue {

    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $clientID;

    public function __construct($clientID) {
        $this->clientID = $clientID;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        //fillTempTableData($this->campaignID);
        deleteUserData($this->clientID);
    }

}

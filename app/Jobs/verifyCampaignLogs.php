<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Artisan;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\RequestException;

class verifyCampaignLogs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $shceduleID;

    public function __construct($shceduleID) {
        $this->shceduleID = $shceduleID;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $client = new GuzzleHttpClient();        
        try {
            $res = $client->get(URL::to("/get-infobip-msg-reports/{$this->shceduleID}"));
        } catch (RequestException $re) {
            echo '401';
        }
    }
}

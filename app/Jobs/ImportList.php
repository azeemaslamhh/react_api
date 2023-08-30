<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\ListOperations;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ImportList implements ShouldQueue {

    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    protected $import_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($import_id) {
        $this->import_id = $import_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $resultListOperations = ListOperations::where(array(
                    'id' => $this->import_id,
                    'type' => 0,
                    'import_status' => 0
        ));
        if ($resultListOperations->count() > 0) {
            $listOperationRow = $resultListOperations->first()->toArray();
            $path = config('app.user_docs') . $listOperationRow['user_id'] . '/subscribers';
            if (file_exists($path . '/' . $listOperationRow['file_name'])) {
                $handle = @fopen($path . $listOperationRow['file_name'], 'r');
                $totalRow = getNoofRowsinFile($filePath . $file_name);
                $params = json_decode($listOperationRow['meta_data'],true);
                 $addedContactCount = DB::table('mobile_subscribers')->where(array('user_id' => session()->get('id'), 'is_deleted' => 0))->count();
                if($params['contains_header']){
                    $totalRow = $totalRow - 1;
                    $totalContact = $totalRow + $addedContactCount;
                }
                
            } else {
                Log::info('Error: File not exist');
            }
        } else {
            Log::info('Error: import id not exist');
        }
    }

}

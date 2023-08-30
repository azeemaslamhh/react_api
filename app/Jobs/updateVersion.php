<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Artisan;
use Chumper\Zipper\Facades\Zipper;
use Illuminate\Support\Facades\DB;
use App\System_settings;
use App\Version_history;

class updateVersion implements ShouldQueue {

    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function handle() {
        set_time_limit(0);
        $base_path = base_path();
        $src_file = 'http://smsplus.update.mumara.com/upgrade-sms-mumara.zip';
        $dest_file = $base_path . '/assets/upgrade-sms-mumara.zip';
        if (file_exists($dest_file))
            unlink($dest_file);



        System_settings::where('setting_name', 'upgrading_status')
                ->update([
                    'setting_value' => 1
        ]);
        try {
            copy($src_file, $dest_file);
            chmod($dest_file, 0777);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
        echo '<br />copy files done';
        try {
            System_settings::where('setting_name', 'upgrading_status')
                    ->update([
                        'setting_value' => 2
            ]);
            Zipper::make($dest_file)->extractTo($base_path . '/update');
            chmod($base_path . '/update', 0777);
            echo '<br />extracting files done';
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        try {
            $source = base_path() . '/update';
            $target = base_path();
            System_settings::where('setting_name', 'upgrading_status')
                    ->update([
                        'setting_value' => 3
            ]);
            full_copy($source, $target);
            echo '<br />install files done';
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
        System_settings::where('setting_name', 'upgrading_status')
                ->update([
                    'setting_value' => 4
        ]);
        if (file_exists($base_path . '/site.sql')) {

            $filename = $base_path . "/site.sql";
            $fp = fopen($filename, "r");

            $content = fread($fp, filesize($filename));
            $queries = explode(';', $content);

            foreach ($queries as $query) {
                try {
                    DB::statement($query . ';');
                } catch (\Exception $e) {
                    //echo $e->getMessage();
                    //echo 'Query already executed';
                }
            }
            echo '<br />sql files done';
            fclose($fp);
        }





        try {
            System_settings::where('setting_name', 'upgrading_status')
                    ->update([
                        'setting_value' => 5
            ]);
            rrmdir($source);
            if (file_exists($base_path . '/assets/upgrade-sms-mumara.zip'))
                @unlink($base_path . '/assets/upgrade-sms-mumara.zip');

            if (file_exists($base_path . '/site.sql'))
                @unlink($base_path . '/site.sql');


            echo '<br />delete temp files done';
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        System_settings::where('setting_name', 'upgrading_status')
                ->update([
                    'setting_value' => 0
        ]);

        $versionData = readVersionFile();

        $versionDetailData = preg_split('/\r\n|\r|\n/', $versionData);
        $description = '';
        $version = '';
        if (count($versionDetailData) > 0) {
            $version = $versionDetailData[0];
            foreach ($versionDetailData as $key => $line) {
                if ($key != 0) {
                    $description .= $line;
                }
            }
        }

        $objVersionHistory = new Version_history();
        $versionData = array(
            'versions' => $version,
            'description' => $description,
            'updated_date' => gmdate("Y-m-d H:i:s"),
        );
        $objVersionHistory->fill($versionData);
        $objVersionHistory->save();
        System_settings::where('setting_name', 'system_update')
                ->update([
                    'setting_value' => 'off'
        ]);
        die("<br />files have been copied");
    }

}

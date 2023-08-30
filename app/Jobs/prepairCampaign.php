<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\prepairCampaigns;
use Illuminate\Support\Facades\DB;
use App\Schedulecampaigns;
use App\Subscribers;
use Illuminate\Support\Facades\File;
use App\Sms_threads;

class prepairCampaign implements ShouldQueue {

    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $scheduleID;
    protected $list_id_array;
    protected $applicationSettings;
    protected $scheduleData;
    protected $senderIDs;
    protected $suppresedMobileNumbers;
    protected $default_fields;
    protected $cus_fields;
    protected $batch_no;
    protected $gateway_id = '';
    protected $file_path = '';
    protected $senderIdCount;
    protected $records_per_file;
    protected $start = 0;
    protected $gateways = array();
    protected $i;
    protected $tblPrefix;

    public function __construct($campaignID) {
        $this->scheduleID = $campaignID;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        ini_set('max_execution_time', 0);
        try {
            $id = $this->scheduleID;
            $this->batch_no = 1;


            $gatewaysData = getAllApis();
            foreach ($gatewaysData as $key => $gateway) {
                $this->gateways[$key] = 0;
            }

           
            $this->scheduleData = $this->getScheduleCampaignData($id);
            $default_threads = 10;
            $total_count = $this->scheduleData['total_count'];
            if ($total_count > $default_threads) {
                $thread_count = $total_count / $default_threads;
                $thread_count = round($thread_count);
                if ($thread_count > 5000)
                    $thread_count = 5000;
            } else
                $thread_count = $default_threads;

            $this->records_per_file = $thread_count;


            //total_count
            $this->applicationSettings = getAdminSettings();
            $this->senderIDs = getSenderIdsByScheduleID($id);
            $this->list_id_array = explode(',', $this->scheduleData['list_id']);
            $this->suppresedMobileNumbers = getSuppressContects($this->scheduleData['user_id'], $this->list_id_array);
            $this->default_fields = array('first_name', 'last_name', 'mobile_no', 'country');
            $this->cus_fields = getCustomFields($this->scheduleData['user_id']);

            updateCampaignStatus($id, gmdate('Y-m-d H:i:s'), 9);
            $this->i = 0;
            //$this->fillTempTable($this->list_id_array, $id, 0, $this->applicationSettings['record_batch_size'], $this->scheduleData['total_count'], $this->scheduleData, $this->senderIDs, $this->suppresedMobileNumbers, $this->default_fields, $this->cus_fields);
            $this->fillTempTable();
            //echo '<br />----------------------<pre>';
            //print_r($this->gateways);
            //echo '</pre>';
            updateCampaignStatus($id, gmdate('Y-m-d H:i:s'), 1);
            $dir = storage_path() . DIRECTORY_SEPARATOR . "campaigns" . DIRECTORY_SEPARATOR . $id;
            $file_names = getDirContents($dir);
            foreach ($file_names as $file_path) {
                $objSmsThreads = new Sms_threads();
                $env = config('app.env');
                if (($env == 'development' || $env == 'production')) {
                    $arrayGateway = explode('campaigns', $file_path);
                    $arrayGateway2 = explode('/', $arrayGateway[1]);
                } else {
                    $strGateway = str_replace("\\", "-", $file_path);
                    $arrayGateway = explode('campaigns', $strGateway);
                    $arrayGateway2 = explode('-', $arrayGateway[1]);
                }

                //echo '<br />'.$arrayGateway2[1]; 

                $objSmsThreads->fill(array('schedule_id' => $id, 'file_name' => $file_path, 'gateway_id' => $arrayGateway2[2]));
                $objSmsThreads->save();
            }


            //InsertDailySMSCount($this->scheduleData['user_id'], 0, $this->scheduleData['time_zone']);
            $sendingDate = getMyTime($this->scheduleData['send_time'], $this->scheduleData['time_zone']);
            getUserDailyLimit($this->scheduleData['user_id'], $sendingDate, $this->scheduleData['time_zone']);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getScheduleCampaignData($id) {

        return $result = Schedulecampaigns::select('campaigns_schedule.id', 'campaigns_schedule.schedule_label', 'campaigns_schedule.list_id', 'campaigns_schedule.campaign_id', 'campaigns_schedule.send_time', 'campaigns_schedule.status', 'campaigns_schedule.added_by'
                                , 'campaigns_schedule.total_count', 'c.user_id', 'c.message', 'p.pkg_type', 'p.id as p_id', 'u.time_zone', 'p.hourly', 'p.daily')
                        ->join('campaigns as c', 'c.id', '=', 'campaigns_schedule.campaign_id')
                        ->join('users as u', 'c.user_id', '=', 'u.id')
                        ->join('user_pkgs as up', 'up.user_id', '=', 'c.user_id')
                        ->join('packages as p', 'up.pkg_id', '=', 'p.id')
                        ->where('campaigns_schedule.id', $id)->first()->toArray();
    }

    public function fillTempTable() {
        ini_set('max_execution_time', 0);
        $this->tblPrefix = config('app.tbl_prefix');
        $this->senderIdCount = count($this->senderIDs);
        //->selectRaw("SUM(sent_counter) as sent_counter,SUM(delivered_counter) as delivered_counter, SUM(failed_counter) as failed_counter ")
        Subscribers::selectRaw("distinct({$this->tblPrefix}mobile_subscribers.mobile_no) as mobile_no,{$this->tblPrefix}mobile_subscribers.id,{$this->tblPrefix}mobile_subscribers.status,{$this->tblPrefix}mobile_subscribers.first_name,{$this->tblPrefix}mobile_subscribers.last_name,{$this->tblPrefix}mobile_subscribers.country")
                ->whereIn('mobile_subscribers.list_id', $this->list_id_array)
                ->where('mobile_subscribers.is_deleted', 0)
                ->groupBy('mobile_subscribers.mobile_no')->chunk($this->applicationSettings['record_batch_size'], function ($subcriberResult) {

//                    echo '<pre>';
//                    print_r($subcriberResult);
//                    exit;

            $subCount = count($subcriberResult);
            $changeSenderCount = ceil($subCount / $this->senderIdCount); //$subCount/$this->senderIdCount;
            if ($this->applicationSettings['record_batch_size'] < $this->senderIdCount) {
                for ($i = 0; $i < $this->senderIdCount; $i++) {
                    $randomNumber[] = $i;
                }
            }

            $campaigns_gene_dir = storage_path() . DIRECTORY_SEPARATOR . "campaigns" . DIRECTORY_SEPARATOR . $this->scheduleID;

            if (!is_dir($campaigns_gene_dir)) {
                File::makeDirectory($campaigns_gene_dir, 0777, true);
            }

            $s = 1;
            $k = 0;

            foreach ($subcriberResult as $subscriberRow) {


                if ($this->applicationSettings['record_batch_size'] < $changeSenderCount) {
                    $j = array_rand($randomNumber);
                    if (array_key_exists($j, $this->senderIDs))
                        $senderIDArray = $this->senderIDs[$j];
                    else
                        $senderIDArray = $this->senderIDs[0];
                } else {
                    if ($s % $changeSenderCount == 0) {
                        $k++;
                    }
                    if (array_key_exists($k, $this->senderIDs))
                        $senderIDArray = $this->senderIDs[$k];
                    else
                        $senderIDArray = $this->senderIDs[0];
                }
                $priorityData = getSendingPriority($subscriberRow->id, $senderIDArray['id']);




                $isAttemped = 0;
                $processingType = 1;
                $subscriberId = $subscriberRow->id;
                $mobileNo = $subscriberRow->mobile_no; //rspecial($subscriberRow->mobile_no);
                if ($mobileNo == "" || !is_numeric($mobileNo))
                    $processingType = 3;
                else if (pluginCheck('Validation') == 0 && $isAttemped == 0 && ($subscriberRow->status == 2 || $subscriberRow->status == 3))
                    $processingType = 0;
                else if (in_array($mobileNo, $this->suppresedMobileNumbers))
                    $processingType = 4;
                else if (isAllowCountry($mobileNo, $this->scheduleData['user_id']) == 0)
                    $processingType = 5;

                $message_body = $this->scheduleData['message'];
                foreach ($this->default_fields as $default_field) {
                    if ($default_field == 'country') {
                        if ($subscriberRow->$default_field != "") {
                            $countryResult = DB::table('countries')->select('country_name')->where('id', $subscriberRow->$default_field);
                            if ($countryResult->count() > 0) {
                                $countryRow = $countryResult->first();
                                $message_body = str_replace("%%" . $default_field . "%%", $countryRow->country_name, $message_body);
                            } else {
                                $message_body = str_replace("%%" . $default_field . "%%", '', $message_body);
                            }
                        } else {
                            $message_body = str_replace("%%" . $default_field . "%%", '', $message_body);
                        }
                    } else
                        $message_body = str_replace("%%" . $default_field . "%%", $subscriberRow->$default_field, $message_body);
                }

                if (count($this->cus_fields) > 0) {
                    foreach ($this->cus_fields as $key => $field) {
                        $row_custom = DB::table('subscriber_fields')->where(['subscriber_id_fk' => $subscriberId, 'field_id_fk' => $key])->first();
                        if ($row_custom)
                            $message_body = str_replace("%%" . $field . "%%", $row_custom->field_value, $message_body);
                        else
                            $message_body = str_replace("%%" . $field . "%%", ' ', $message_body);
                    }
                }

                $countCharecter = strlen($message_body);
                $totalCredit = $countCharecter / 160;
                $messageCredit = ceil($totalCredit);
                $messageCount = $messageCredit;
                if ($this->scheduleData['pkg_type'] != 3)
                    $messageCredit = getDBMessageCount($this->scheduleData['p_id'], $messageCredit, $subscriberId);

                $countryArray = getCountryByMobile($mobileNo);
                $countryID = (isset($countryArray[0])) ? $countryArray[0] : "";




                foreach ($priorityData as $priority) {
                    if ($priority > 0) {
                        $senderAPIID = $priority;
                        break;
                    }
                }


                if ($senderAPIID == 0)
                    $processingType = 6;

                //echo '<br />p='.$senderAPIID;

                $gateway_id = 0;

                if ($senderAPIID > 0)
                    $gateway_id = DB::table('system_apis')->where('id', $senderAPIID)->value('gateway_id');

                /*
                  echo '<pre>';
                  print_r($this->gateways);
                  echo '</pre>';
                 */
               // echo '<br />variable=' . $senderAPIID;
              //  echo '<br />variable2=' . $this->gateways[$senderAPIID];
              //  echo '<br />---------<br />';
                //exit;

                $campaigns_dir = ($processingType == 1) ? $campaigns_gene_dir . DIRECTORY_SEPARATOR . $senderAPIID : $campaigns_gene_dir . DIRECTORY_SEPARATOR . "0";
                if (!is_dir($campaigns_dir)) {
                    File::makeDirectory($campaigns_dir, 0777, true);
                }


                ///echo '<br >st ='.$this->start;
                if ($this->start == 0) {
                    //echo '<br />start_sender_id=='.$this->gateways[$senderAPIID];
                    $this->file_path = $campaigns_dir . DIRECTORY_SEPARATOR . $this->batch_no . ".csv";
                    $this->gateway_id = $gateway_id;
                    $fp = fopen($this->file_path, 'a');
                } else {
                    $file_path = $campaigns_dir . DIRECTORY_SEPARATOR . $this->batch_no . ".csv";
                    ///echo '<br />g=='.$this->gateways[$senderAPIID];
                    //echo '<br />sender_id=='.$this->gateways[$senderAPIID];
                    $fileSize = ($this->scheduleData['hourly'] == -1) ? $this->records_per_file : $this->scheduleData['hourly'];
                    if ($this->gateways[$senderAPIID] >= $fileSize) { //$this->gateways
                        $this->i = 0;
                        $this->batch_no++;

                        $this->file_path = $campaigns_dir . DIRECTORY_SEPARATOR . $this->batch_no . ".csv";
                        $fp = fopen($this->file_path, 'w');
                        $this->gateways[$senderAPIID] = 0;
                    } else {
                        if ($this->file_path != $file_path) {
                            //fclose($this->file_path);
                            $this->gateway_id = $senderAPIID;
                            $this->file_path = $file_path;
                        }
                        if ($this->gateways[$senderAPIID] == 0) {
                            $fp = fopen($this->file_path, 'w');
                        } else {
                            $fp = fopen($this->file_path, 'a');
                        }
                    }
                }
                echo '= path = ' . $this->file_path . '<br />';



                $this->i++;


                ///echo '<br />' . $mobileNo;


                $tempArray = array(
                    $this->scheduleID,
                    $subscriberId,
                    $mobileNo,
                    $messageCredit,
                    $messageCount,
                    $senderAPIID,
                    $senderIDArray['id'],
                    $senderIDArray['api_id'],
                    $senderIDArray['sender_id'],
                    $message_body,
                    $this->scheduleData['send_time'],
                    implode(",", $priorityData),
                    $processingType,
                    $this->scheduleData['user_id'],
                    $countryID,
                    $this->scheduleData['time_zone'],
                );

                fputcsv($fp, $tempArray);
                $this->gateways[$senderAPIID] ++;
                $this->start++;
            }
        });
    }

}

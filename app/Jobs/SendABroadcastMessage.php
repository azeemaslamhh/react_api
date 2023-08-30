<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use App\Groups;
use App\Packages;
use App\Users;
use App\Countries;
use App\Languages;
use Mail;
use App\Admins;
use App\Broadcast_msg_logs;
use App\Sender_ids_gateways;
use App\Senderids;

class SendABroadcastMessage implements ShouldQueue {

    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $params;
    protected $adminSettings = array();
    protected $sendAbroadcastSmsZone;
    protected $gatewayData;
    protected $defaultFields;

    //protected $adminSettings = array();

    public function __construct($params) {
        $this->params = $params;
        /* echo '<pre>';
          print_r($this->params );
          exit;
         */
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        
        $resultUser = Users::join('user_pkgs as up', 'users.id', '=', 'up.user_id')
                        ->join('packages as p', 'up.pkg_id', '=', 'p.id')
                        ->leftjoin('countries as c', 'users.country', '=', 'c.id')
                        ->leftjoin('languages as l', 'users.language', '=', 'l.id')
                        ->join('groups as g', 'p.group_id', '=', 'g.id')
                        ->join('credit_count as cc', 'users.id', '=', 'cc.user_id')->where('users.is_deleted', 0);

       
        if ($this->params['typeCriteria'] == 'all_clients')
            $resultUser->whereIn('users.id', $this->params['clients']);
        else {
            $optionIDs = $this->params['criteriaOption'];

            if ($this->params['criteria'] == 1)  //get groups clients
                $resultUser->whereIn('p.group_id', $optionIDs);
            else if ($this->params['criteria'] == 2) //get package ids clients
                $resultUser->whereIn('p.id', $optionIDs);
            else if ($this->params['criteria'] == 3) // client status
                $resultUser = $resultUser->whereIn('users.status', $optionIDs);
            else if ($this->params['criteria'] == 4) //get counries clients
                $resultUser = $resultUser->whereIn('users.country', $optionIDs);
            else
                $resultUser = $resultUser->whereIn('users.language', $optionIDs);
        }
        $this->defaultFields = $this->params['default_fields'];
        $this->adminSettings = getAdminSettings();
        if ($this->params['sendingType'] == 'sms') {
            $this->gatewayData = getAllApis();
        }
        $userFields = array('users.id', 'users.name', 'users.email', 'users.first_name', 'users.last_name', 'users.city', 'users.zip', 'users.state', 'c.country_name as country', 'users.phone', 'users.mobile_no', 'users.business_number',
            'users.address', 'users.photo', 'users.company_name', 'users.find_us', 'users.signup_ip', 'users.job_title', 'users.website', 'users.skype', 'users.facebook', 'users.linkedin', 'users.twitter', 'users.google', 'l.language', 'p.pkg_name', 'g.group_name', 'cc.credit');
        if ($resultUser->count()) {
            $resultUser->select($userFields)->chunk($this->adminSettings['record_batch_size'], function($clientsData) {
                 /*
                 echo '<pre>';
                 print_r($clientsData);
                 exit;
                 */
                $messageBody = $this->params['message'];
                $j = 1;
                $i = 1;
                $messageArray = array();
                foreach ($clientsData as $clientRow) {
                  //  echo '<br />'.$clientRow['mobile_no'];
                    foreach ($this->defaultFields as $key => $field) {
                        if ($clientRow[$key] != "")
                            $messageBody = str_replace("%%" . $key . "%%", $clientRow[$key], $messageBody);
                        else
                            $messageBody = str_replace("%%" . $key . "%%", '', $messageBody);
                    }

                    if ($this->params['sendingType'] == 'email') { //sending Emial
                        sendSimpleEmail($clientRow['email'], $this->adminSettings['from_email'], $this->adminSettings['from_name'], $this->params['subject'], $messageBody);
                    } else { //sending sms
                        $senderIdData = Senderids::where('id', $this->params['subject'])->select('sender_id', 'api_id')->first()->toArray();
                        $data = array(
                            'mobile_no' => rspecial($clientRow['mobile_no']),
                            'sender_id' => $senderIdData['sender_id'],
                            'message' => $messageBody,
                            'notifyUrl' => '',
                            'click_a_tel_api_id' => $senderIdData['api_id'],
                            'client_id' => $clientRow['id'],
                            'sended_by' => $this->params['admin_id']
                        );
                        /*echo '<pre>';
                        print_r($this->params);
                        exit;
                        */
                        
                        if ($this->adminSettings['broadcasting_through'] == 'zones') {
                            $result = sendSingleMessage($data); 
                        } else { 
                            $result = sendMessageUsingGateway($this->adminSettings['broadcast_gateway'], $data);
                        }
                        saveMessageLog($result, 'broadcast_msg_logs', $this->params['subject'], md5(random_string(50)), $this->params['message_type']);
                    }
                }
            });
        }
    }

    public function infoBipSending($apiID, $priorityData, $data, $priority) {
        $getAllApis = getAllApis();
        if ($getAllApis[1]['status'] == 'inactive' && $getAllApis[2]['status'] == 'inactive' && $getAllApis[3]['status'] == 'inactive') {
            // send email to Admin all gateways have been inactive.
            exit;
        }

        $url = "https://82kg3.api.infobip.com/sms/2/text/advanced";
        $result = sendMessagesInfobip($this->gatewayData[1]['secret_key'], $data['sParam'], $url);
        if ($result == "401" || $result == "error") {
            updateApi(1);
            $this->onFailedAPi($apiID, $priorityData, $data, $priority);
        } else {
            $arrayResult = json_decode($result);

            $statuses = $arrayResult->messages;

            foreach ($statuses as $res) {
                $responseRow = getMessageResponse($res->status->name);
                $broadcastArray = array(
                    'client_id' => $data['client_id'],
                    'message' => $data['sParam']['messages'][0]['text'],
                    'sended_by' => $data['admin_id'],
                    'gateway_id' => 1,
                    'message_id' => $res->messageId,
                    'response_id' => $responseRow->gateway_response_id,
                    'is_sent' => $responseRow->is_sent,
                    'sender_id' => $data['sParam']['messages'][0]['from'],
                    'broadcast_id' => $data['broadcast_id']
                );
                //print_r($broadcastArray); exit;
                $this->saveSystemStats($broadcastArray);
            }
        }
    }

    public function clickATellSending($apiID, $priorityData, $data, $priority) {
        $getAllApis = getAllApis();
        if ($getAllApis[1]['status'] == 'inactive' && $getAllApis[2]['status'] == 'inactive' && $getAllApis[3]['status'] == 'inactive') {
            // send email to Admin all gateways have been inactive.
            exit;
        }
        //click_a_tel_api_id
        $clickATelApiID = $this->adminSettings['click_a_tel_api_id'];
        //($getAllApis, $mobileNumber, $messages, $apiId, $from)
        $result = sendMessageByUsingClickAtell($getAllApis, $data['sParam']['messages']['destinations']['0']['to'], $data['sParam']['messages']['text'], $clickATelApiID, $data['sParam']['messages']['from']);
        $messageId = random_string(50);
        if ($result != '401' && $result != '301') {

            $broadcastArray = array(
                'client_id' => $data['client_id'],
                'message' => $data['sParam']['messages'][0]['text'],
                'sended_by' => $data['admin_id'],
                'gateway_id' => 2,
                'sender_id' => $data['sParam']['messages'][0]['from'],
                'broadcast_id' => $data['broadcast_id']
            );

            if (isset($result['status']) && $result['status'] == "Pending") {
                $responseRow = getMessageResponse($result['status']);
                $sendStatus = ($responseRow->is_sent == 1) ? "Pending" : "failed";
                $broadcastArray['message_id'] = $result['messageID'];
                $broadcastArray['response_id'] = $result['messageID'];
                $broadcastArray['is_sent'] = $sendStatus;
            } else if (isset($result['error']) && $result['error'] != "") {

                $responseRow = getMessageResponse($result['error']);

                $sendStatus = ($messageRow->is_sent == 0) ? 'Faield' : 'Sent';
                $broadcastArray['message_id'] = $result['messageID'];
                $broadcastArray['response_id'] = $result['messageID'];
                $broadcastArray['is_sent'] = $sendStatus;
            } else {
                $responseRow = getMessageResponse($result['status']);
                $messageId = random_string(50);
                $broadcastArray['message_id'] = $messageId;
                $broadcastArray['response_id'] = $result['messageID'];
                $broadcastArray['is_sent'] = $sendStatus;
            }
            $this->saveSystemStats($broadcastArray);
        } else {

            updateApi(2);
            $this->onFailedAPi($apiID, $priorityData, $data, $priority);
        }
    }

    public function twilioSending($apiID, $priorityData, $data, $priority) {
        $getAllApis = getAllApis();
        if ($getAllApis[1]['status'] == 'inactive' && $getAllApis[2]['status'] == 'inactive' && $getAllApis[3]['status'] == 'inactive') {
            // send email to Admin all gateways have been inactive.
            exit;
        }
        $messageId = random_string(50);
        $broadcastArray = array(
            'client_id' => $data['client_id'],
            'message' => $data['sParam']['messages'][0]['text'],
            'sended_by' => $data['admin_id'],
            'gateway_id' => 3,
            'message_id' => $messageId,
            'sender_id' => $data['sParam']['messages'][0]['from'],
            'broadcast_id' => $data['broadcast_id']
        );
        $id = $this->saveSystemStats($broadcastArray);
        $adminToken = getAdminToken($data['admin_id']);
        $notifyUrl = url('broadcast-twelio-callback') . '?token=' . $adminToken . '&id=' . $id;
        $result = sendMessagesTwilio($getAllApis[3]['api_key'], $getAllApis[3]['secret_key'], $data['sParam']['messages']['from'], $data['sParam']['messages']['destinations']['0']['to'], $data['sParam']['messages']['text'], $callBackUrl);
        //$result = sendMessagesTwilio($getAllApis[3]['api_key'], $getAllApis[3]['secret_key'], $senderIDDetail['sender_id_text'], $data['sParam']['destinations']['0']['to'], $data['sParam']['text'], $notifyUrl);


        if ($result['request_status'] == '401') {
            updateApi(3);
            $this->onFailedAPi($apiID, $priorityData, $data, $priority);
        } else {

            $responseRow = getMessageResponse($result['message_status']);
            $sendStatus = ($responseRow->is_sent == 0) ? 'failed' : 'Pending';

            $updateData = array(
                'is_sent' => $responseRow->is_sent,
                'response_id' => 10
            );
            $objBroadcastMsgLogs = Broadcast_msg_logs::find($id);
            $objBroadcastMsgLogs->fill($updateData);
            $objBroadcastMsgLogs->save();
        }
    }

    public function saveSystemStats($broadcastArray) {
        $count = Broadcast_msg_logs::where(array('client_id' => $broadcastArray['client_id'], 'broadcast_id' => $broadcastArray['broadcast_id']))->count();
        if ($count == 0) {
            $objBroadCast = new Broadcast_msg_logs();
            $objBroadCast->fill($broadcastArray);
            $objBroadCast->save();
            return $objBroadCast->id;
        } else
            return 0;
    }

    function checkApiStatus() {

        $apiData = getAllApis();
        if ($apiData[1]['status'] == 'inactive' && $apiData[2]['status'] == 'inactive' && $apiData[3]['status'] == 'inactive') {
            echo 'All Api has been Inactive';
            return 1;
        } else {
            return 0;
        }
    }

    public function onFailedAPi($apiID, $priorityData, $data, $failPriority) {

        if ($this->checkApiStatus() != 1) {
            if ($failPriority == 'primary_api')
                $priority = 'secondry_api';
            else if ($failPriority == 'secondry_api')
                $priority = 'third_api';
            else {
                // Send email to Admin All APi has been inactive
                die("All Apis have been inactive");
            }

            if ($priorityData[$priority] == 1) {
                $this->infoBipSending($apiID, $priorityData, $data, $priority);
            } else if ($priorityData[$priority] == 2) {
                $this->clickATellSending($apiID, $priorityData, $data, $priority);
            } else {
                $this->twilioSending($apiID, $priorityData, $data, $priority);
            }
        }
    }

}

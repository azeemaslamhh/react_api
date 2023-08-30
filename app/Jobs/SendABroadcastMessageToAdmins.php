<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\Admins;
use App\Models\Senderids;

class SendABroadcastMessageToAdmins implements ShouldQueue {

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

    public function __construct($params) {
        $this->params = $params;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $this->adminSettings = getAdminSettings();

        if (count($this->params['roles']) > 0) {
            $adminsResult = Admins::whereIn('role_id', $this->params['roles'])->where('is_deleted', 0);
            if ($adminsResult->count() > 0) {
                $adminsData = $adminsResult->get()->toArray();
                
                foreach ($adminsData as $adminsRow) {
                    $email_template = replaceAdminVariables($this->params['email_template'],$adminsRow['id']);
                    $sms_template = replaceAdminVariables($this->params['sms_template'],$adminsRow['id']);
                    
                    if ($this->params['email_flag'] == 'on')
                        sendSimpleEmail($adminsRow['email'], $this->adminSettings['from_email'], $this->adminSettings['from_name'], $this->params['subject_title'], $email_template);
                   
                    if ($this->params['sms_flag'] == 'on' && $adminsRow['mobile_no'] != "") {
                        $senderIdData = Senderids::where('id', $this->adminSettings['default_sender_id'])->select('id', 'sender_id', 'api_id')->first()->toArray();

                        $data = array(
                            'mobile_no' => rspecial($adminsRow['mobile_no']),
                            'sender_id' => $senderIdData['sender_id'],
                            'message' => $sms_template,
                            'notifyUrl' => '',
                            'click_a_tel_api_id' => $senderIdData['api_id'],
                            'admin_id' => $adminsRow['id'],
                            'sended_by' => $this->params['admin_id']
                        );
                        if ($this->adminSettings['broadcasting_through'] == 'zones') {
                            $result = sendSingleMessage($data, 'admin');
                        } else {
                            $result = sendMessageUsingGateway($this->adminSettings['broadcast_gateway'], $data);
                        }
                        saveMessageLog($result, 'broadcast_msg_logs', $senderIdData['id'], md5(random_string(50)), $this->params['message_type']);
                    }
                    //end  send SMS
                }
            }
        }
        //sendSimpleEmail($request->email, $this->defaultApplicationSettings['from_email'], $this->defaultApplicationSettings['from_name'], $templateData['subject_title'], $email_template);
    }

}

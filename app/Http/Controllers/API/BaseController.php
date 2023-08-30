<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Application_settings;
use Carbon\Carbon;

class BaseController extends Controller {

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */


    public function sendResponse($result, $message) {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];


        return response()->json($response, 200);
    }
    public function apiResponse($result) {
        return response()->json($result, 200);
    }
    public function loginSendResponse($result) {
        return response()->json($result, 200);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404) {
        $response = [
            'login_status' => 0,
            'message' => $error,
            'code'=>710
        ];


        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }

    public function verifyToken($bearerToken) {
        try {
            
            $token_expire_hours = $this->getAdminSetting('token_expire'); 
            if ($bearerToken != "") {
                $result = DB::table('users')->where(array('token' => $bearerToken));
                if ($result->count() > 0) {                    
                    if ($token_expire_hours != -1) {
                        $token_create_date = $result->value('token_create_date');
                        $expire_date = Carbon::parse($token_create_date)->addHours($token_expire_hours);
                        $currentDate = date("Y-m-d H:i:s");
                        if ($expire_date < $currentDate) {                           
                           return response()->json(array('success'=>'false','message'=>"token_expire","data"=>array('error'=>'token_expire')));                           
                        }
                    }
                    return true;
                }
            }            
            return response()->json(array('success'=>'false','message'=>trans('client.api_login.unauthorised'),"data"=>array('error'=>trans('client.api_login.unauthorised'))));
        } catch (\Exception $e) {            
            return response()->json(array('success'=>'false','message'=>$e->getMessage(),"data"=>array('error'=>$e->getMessage())));
           
        }
    }

    public function getAdminSetting($setting) {
        
        return  Application_settings::where('setting_name',$setting)->value('setting_value');
        
    }

}

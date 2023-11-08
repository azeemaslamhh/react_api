<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Application_settings;
use Carbon\Carbon;

class VerifyToken
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $headers = \Request::header();
            /* echo '<pre>';
              print_r($request->api_token);
              exit;
             */
            $bearerToken = $request->api_token; //\Request::bearerToken(); //$request->bearerToken(); 
            if (empty($bearerToken)) {
                //$bearerToken = $request->api_token;
                return response()->json(array('status' => 'false', 'message' => trans('client.empty_api_token'), 'code' => 700), 200);
                //echo json_encode(array('status' => 'false', 'message' => trans('client.empty_api_token'), 'code' => 700));
                //exit;
            }

            $res = $this->verifyToken($bearerToken, $request->user_id);
            if ($res['code'] != 200) {
                return response()->json(array('status' => 'false', 'message' => $res['message'], 'code' => $res['code']), 200);
                //echo json_encode(array('status' => 'false', 'message' => $res['message'], 'code' => $res['code']));
                ///exit;
            }
        } catch (\Exception $e) {
            return array('code' => 500, 'message' => $e->getMessage(), 'status' => 'faile');
            //echo json_encode(array('status'=>'faile','message'=>$e->getMessage(),'code'=>500)); 
            ///exit;
        }



        return $next($request);
    }


    public function verifyToken($bearerToken, $user_id)
    {

        try {

            // die("token : ".$bearerToken);
            $token_expire_hours = -1; //$this->getAdminSetting('token_expire');
            if ($bearerToken != "") {
                $result = DB::table('users')->where(array('token' => $bearerToken, 'id' => $user_id));
                $token_expire_hours = $this->getAdminSetting('token_expire');
                // die("token : " . $token_expire_hours);

                if ($result->count() > 0) {
                    if ($token_expire_hours != -1) {
                        $token_create_date = $result->value('token_create_date');
                        $expire_date = Carbon::parse($token_create_date)->addHours($token_expire_hours);
                        $currentDate = date("Y-m-d H:i:s");
                        if ($expire_date < $currentDate) { //die("hhhh");                          
                            return array('code' => 501, 'message' => trans('client.api_token_expired'));
                        }
                    }
                    return array('code' => 200, 'message' => "");
                    //return 200;
                }
            }
            return array('code' => 710, 'message' => trans('client.api_login.unauthorised'));
        } catch (\Exception $e) {
            return array('code' => 700, 'message' => $e->getMessage());
        }
    }

    public function getAdminSetting($setting)
    {
        return Application_settings::where('setting_name', $setting)->value('setting_value');
    }
}

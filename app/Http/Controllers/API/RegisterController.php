<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\Users;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use App\Models\Countries;
use App\Models\UserSettings;
use App\Models\Packages;
use App\Classes\CommonClass;
use App\Models\Notification_module_templates;
use App\Models\Notification_templates;

class RegisterController extends BaseController {

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    private $systemKey = '';
    public $defaultApplicationSettings = array();

    public function __construct() {
        $this->systemKey = config('app.SYSTEM_KEY');
        $this->defaultApplicationSettings = getAdminSettings();
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request) {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken($request->email)->plainTextToken;
            $user['user_id'] = $user->id;
            $user['name'] = $user->name;
            $user['success'] = true;
            $user['login_status'] = 1;
            $user['code'] = 200;
            ///User::where('id', $user->id)->update(array('token' => $token, 'token_create_date' => date('Y-m-d H:i:s')));
            
            return $this->loginSendResponse($user);
        } else {
            return $this->sendError('Unauthorised.', ['error' => trans("client.api_login.unauthorised")]);
        }
    }

    public function createUser(Request $request) {

        $code = 200;
        try {

            $param = [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email',
                'mobile_no' => 'required',
                'password' => 'required',
            ];

            $validator = Validator::make($request->all(), $param);
            if ($validator->fails()) {
                $messages = $validator->errors()->messages();
                return response()->json(array('status' => 'fails', 'message' => "validation failed", "data" => $messages, 'code' => 700), 200);
            }
            if (strlen($request->password) < 6) {
                $status = 'password_length';
                $message = trans('client.signup_api.min_length');
                $code = 700;
            } else {
                $mobileNo = rspecial($request->mobile_no);

                $clientData = array(
                    'name' => $request->first_name . ' ' . $request->last_name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'mobile_no' => $mobileNo,
                );
                $emailConfirm = 1;
                $status = 'success';
                $countEmail = Users::where(array('email' => $request->email, 'is_deleted' => 0))->count();
                $objUsers = new Users();
                if ($countEmail > 0) {
                    $status = 'duplicate_email';
                    $message = trans('client.signup_api.duplicate_email');
                    $message = str_replace("%%client_email%%", $request->email, $message);
                    $code = 716;
                } else {
                    $countMobile = Users::where(array('mobile_no' => $request->mobile_no, 'is_deleted' => 0))->count();
                    if ($countMobile > 0) {
                        $status = 'duplicate_mobile';
                        $message = trans('client.signup_api.duplicate_mobile_no');
                        $message = str_replace("%%client_mobile_no%%", $request->mobile_no, $message);
                        $code = 716;
                    } else {

                        $message = trans('client.signup_api.success_message_whmcs');
                        $message = str_replace("%%first_name%%", $request->first_name, $message);
                        $objUsers->fill($clientData);
                        if ($objUsers->save()) {
                            
                        } else {
                            $status = 'fail';
                            $message = trans('file.errors.msg');
                            $code = 702;
                        }
                    }
                }
            }
            $outputArray = array('status' => $status, 'message' => $message, 'code' => $code);
            return response()->json($outputArray, 200);
        } catch (\Exception $e) {
            return response()->json([
                        'status' => 'Exception',
                        'message' => $e->getMessage(),
                            ], 500);
        }
    }

}

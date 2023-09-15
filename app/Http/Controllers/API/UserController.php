<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class UserController extends BaseController
{
    public function updateUser(Request $request)
    {
       
        $addList = [
            'name' => 'required|string',
            'mobile_no' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',

        ];
        $validator = Validator::make($request->all(), $addList);
        if ($validator->fails()) {
            $messages = $validator->errors()->messages();
            return response()->json(array('status' => 'false', 'message' => "validation failed", "data" => $messages, 'code' => 700), 200);
        }

        $user = User::findOrFail($request->user_id);
        $user->name = $request->name;
        $user->mobile_no = $request->mobile_no;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->save();
        return response()->json(['success' => 'User updated successfully', 'data' => $user]);
    }
}

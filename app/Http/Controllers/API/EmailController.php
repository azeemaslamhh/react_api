<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmailController extends BaseController {

    public function sendEmail(Request $request) {
   
        $addList = [
            'email' => 'required|email',
            'name' => 'required|string',
            'message' => 'required|string',
            'phone' => 'required|string',
        ];
        $validator = Validator::make($request->all(), $addList);
        if ($validator->fails()) {
            $messages = $validator->errors()->messages();
            return response()->json(array('status' => 'false', 'message' => "validation failed", "data" => $messages, 'code' => 700), 200);
        }

        /*
          // Send the email
          $emailData = $request->only(['email', 'name', 'message', 'phone']);
          $toEmail = 'recipient@example.com'; // Change this to the recipient's email address
          Mail::to($toEmail)->send(new \App\Mail\SendEmail($emailData));
          // Save email content to a JSON file
          $jsonFileName = 'email_content.json';
          Storage::append($jsonFileName, json_encode($emailData));
         */
        return response()->json(['message' => 'Email sent successfully']);
    }

}

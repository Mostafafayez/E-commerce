<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\users;
use App\Models\Otps;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

use App\Mail\OtpMail; // Import the mail class
use Illuminate\Support\Facades\Mail;
class reset_password extends Controller
{

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phonenum1' => 'required|string|exists:users,phonenum1',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 400);
        }

        // Check if the phone number exists in the users table
        $user = users::where('phonenum1', $request->phonenum1)->first();

        if (!$user) {
            return response()->json(['message' => 'Phone number does not exist in the users table.'], 400);
        }

        // Generate a unique OTP
        $otp = Str::random(6); // Adjust the length of OTP as needed

        // Store the OTP in the otps table
        Otps::updateOrCreate(
            ['phone' => $request->phonenum1],
            ['otp' => Hash::make($otp), 'expires_at' => now()->addMinutes(15)]
        );


        $this->sendMessage($request->phonenum1,$otp );

        // Return response with a message
        return response()->json(['message' => 'An OTP has been sent to your phone number. Please check and use it to reset your password.'], 200);
    }

    public function sendMessage($phone , $otp)
    {
        try {
            // Ensure the phone number has the prefix "+2"
            $phone = "+2".$phone;

            // Prepare the request data
            $data = [
                'messaging_product' => 'whatsapp',
                'to' => $phone,
                'type' => 'template',
                'template' => [
                    'name' => 'hello_world',
                    'language' => ['code' => 'en_US'],
                    // 'parameters' => [
                    //     [
                    //         'name' => 'otp',
                    //         'value' => $otp
                    //     ]
                    // ]
                ]
            ];

            // Send the POST request to Facebook Graph API
            $response = Http::withToken('EAANLwZCBJZA6kBO5FE81RpG6idqJ18JIwYnknUX8ZBH3u6mcauG6Liav2CtxaZBnQOKW8BLiICEUlxVZABaFcferfnkPjv4jxNmjKVXNZBjnq8dKHRa0LruU9JIbDWFsPTYjz0paZCAEDf51XXaxYQuNGU4I1jasKGx5RjfTIEfTjZCNuY23Mj4bFDFoUGOXrTbsMvdZCsuHGH1yZC2nU4pIsZD')
                           ->post('https://graph.facebook.com/v18.0/270974746093104/messages', $data);
                           var_dump($response);
            // Check if the response was successful
            if (!$response->successful()) {
                // If the response is not successful, return the error message
                return response()->json(['message' => 'Failed to send OTP message.'], $response->status());
            }


            // Return the successful response
            return $response->json();
        } catch (\Exception $e) {
            // If an exception occurs, return the error message
            return response()->json(['message' => 'Failed to send OTP message. ' . $e->getMessage()], 500);
        }
    }



    public function verifyAndResetPassword(Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 400);
        }

        // Verify OTP (Magic Spell) and retrieve user
        $otp = Otps::where('email', $request->email)->first();

        if (!$otp || !Hash::check($request->otp, $otp->otp)) {
            return response()->json(['message' => 'Invalid or expired magic spell! Please try again.'], 400);
        }

        // Update user's password
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete the used OTP (Magic Spell) from the otps table
        $otp->delete();

        // Return a fun success message
        return response()->json(['message' => 'Congratulations! 🎉 Your password has been successfully reset.'], 200);
    }






}

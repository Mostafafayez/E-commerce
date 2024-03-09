<?php

namespace App\Http\Controllers;

use App\Models\users;
use Illuminate\Support\Facades\Hash; // Import Hash facade
use Illuminate\Http\Request;

class login extends Controller
{





    public function login(Request $request)
    {
        // Validate the request data
        $request->validate([
            'phone' => 'required',
            'password' => 'required',
        ]);

        // Retrieve the user by phone number
        $user = users::where('phonenum1', $request->phone)->first();

        // Check if a user was found and if the password is correct
        if ($user && Hash::check($request->password, $user->password)) {
            // Authentication successful
            // Define user role based on your application logic
            $userRole = $user->type_id;
            $response = [

                'user' => $user,
                'type' => ($userRole == 1) ? 'admin' : 'user',
            ];
            return response()->json($response,  200);
        } else {

            return response()->json(['message' => 'Phone or password is incorrect'], 401);
        }
    }


    public function sign_up(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phonenum1' => 'required|string|max:20',
            'phonenum2' => 'required|string|max:20',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        // Check if email or phone number already exists
        if (users::where('email', $request->email)->exists() || users::where('phonenum1', $request->phonenum1)->exists()) {
            return response()->json(['message' => 'Email or phone number already exists'], 400);
        }

        // Hash the password
        $hashedPassword = Hash::make($request->password);

        // Create a new user record with user_id = 2
        $user = users::create([
            'type_id' => 2,
            'name' => $request->name,
            'address' => $request->address,
            'phonenum1' => $request->phonenum1,
            'phonenum2' => $request->phonenum2,
            'email' => $request->email,
            'password' => $hashedPassword,
        ]);

        // Return a response indicating success or failure
        if ($user) {
            return response()->json(['message' => 'User registered successfully'], 201);
        } else {
            return response()->json(['message' => 'Failed to register user'], 500);
        }
    }





        public function updateUserInfo(Request $request, $id)
        {



            // Validate the request data
            $request->validate([
                'name' => 'nullable|string|max:255',
                'address' => 'nullable|string|max:255',
                'phonenum1' => 'nullable|string|max:20',
                'phonenum2' => 'nullable|string|max:20',

            ]);



     $user = users::findOrFail($id) ;


            if (!$user) {
                return response()->json(["error" => "No user found"], 404);
            }

            // Update user information
            if ($request->filled('name')) {
                $user->name = $request->name;
            }

            if ($request->filled('address')) {
                $user->address = $request->address;
            }
            if ($request->filled('phonenum1' )) {
                $user->phonenum1 = $request->phonenum1;
            }

            if ($request->filled('phonenum2')) {
                $user->phonenum2 = $request->phonenum2;
            }

         // Save the updated user information
            $user->save();

            // Return a response indicating success
            return response()->json(['message' => 'User information updated successfully', $user], 200);
        }

     /*public function updatenum(request $request,$id){


    $request->validate([
        // 'name' => 'nullable|string|max:255',
        // 'address' => 'nullable|string|max:255',
        'phonenum1' => 'required|string|max:20',
        'phonenum2' => 'required|string|max:20',

    ]);

    $user = users::findOrFail($id);


        if ($request->filled('phonenum1' )) {
                $user->phone = $request->phonenum1;
            }

            if ($request->filled('phonenum2')) {
                $user->phone = $request->phone;
            }





            // Save the updated user information
            $user->save();

            // Return a response indicating success
            return response()->json(['message' => 'User information updated successfully'], 200);
        }*/




        public function getusers(){
            $user = users::all();

            return response()->json($user, 200);


        }



}











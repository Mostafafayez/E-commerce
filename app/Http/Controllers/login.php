<?php

namespace App\Http\Controllers;

use App\Models\Users; 
use Illuminate\Support\Facades\Hash; // Import Hash facade
use Illuminate\Http\Request;

class login extends Controller
{
 


    
  
    public function login(Request $request)
    {
        // Validate the request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        // Retrieve the user by email
        $user = Users::where('email', $request->email)->first();
    
        // Check if a user was found and if the password is correct
        if ($user && $request->password === $user->password) {
            // Authentication successful
            // Retrieve the user's role from the database based on user_id
            $userRole = $user->user_id;
            if ($userRole == 1) {
                return response()->json(['type' => 'admin'], 200);
            } elseif ($userRole == 2) {
                return response()->json(['type' => 'user'], 200);
            } else {
                // Unknown user role
                return response()->json(['message' => 'Unknown user role'], 403);
            }
        } else {
            // Authentication failed
            return response()->json(['message' => 'Email or Password is incorrect'], 401);
        }
    }


    
        public function sign_up(Request $request)
        {
            // Validate the request data
            $request->validate([
                'name' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
            ]);
    
            // Hash the password
            $hashedPassword = Hash::make($request->password);
    
            // Create a new user record with user_id = 2
            $user = Users::create([
                'user_id' => 2, // Set user_id to 2
                'name' => $request->name,
                'address' => $request->address,
                'phone' => $request->phone,
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
    }
    




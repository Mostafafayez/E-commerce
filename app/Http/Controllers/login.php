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
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        // Retrieve the user by email
        $user = users::where('email', $request->email)->first();
    
        // Check if a user was found and if the password is correct
        if ($user && Hash::check($request->password, $user->password)) {
            // Authentication successful
            // Retrieve the user's role from the database based on user_id
            $userRole = $user->type_id;
            if ($userRole == 1) {
                return response()->json(['type' => 'admin', 'user' => $user], 200);
            } elseif ($userRole == 2) {
                return response()->json(['type' => 'user', 'user' => $user], 200);
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
                'phonenum1' => 'required|string|max:20',
                'phonenum2' => 'required|string|max:20',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
            ]);
    
            // Hash the password
            $hashedPassword = Hash::make($request->password);
    
            // Create a new user record with user_id = 2
            $user = users::create([
                'type_id' => 2, 
                'name' => $request->name,
                'address' => $request->address,
                'phonenum1' => $request->phone,
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
                'phonenum1' => 'required|string|max:20',
                'phonenum2' => 'required|string|max:20',
                
            ]);
        
            // Find the user by ID
            $user = users::find($id);
        
            // Check if user exists
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
                $user->phone = $request->phone;
            }
        
            if ($request->filled('phonenum2')) {
                $user->phone = $request->phone;
            }




        
            // Save the updated user information
            $user->save();
        
            // Return a response indicating success
            return response()->json(['message' => 'User information updated successfully'], 200);
        }
        
    }
    





<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class categories extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|exists:users,id',
        'image' => 'required|exists:products,id',
       
    ]);










}







    public function getAllcategories()
    {
        // Retrieve all orders with their related user and products
        $orders = categories-> all >get();

        // Return the response with all orders
        return response()->json(['orders' => $orders], 200);
    }

}

<?php

namespace App\Http\Controllers;
use App\Models\categories;
use Illuminate\Http\Request;

class categories extends Controller
{

    public function add_category(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
    
            $category = new Category;
            $category->name = $request->input('name');


            if ($req->hasFile('image')) {
                $fileName = $req->file('image')->store('posts', 'public');
                $product->image = $fileName;
            }

            
            $category->save();
    
            // Return a more informative response
            return response()->json(["Result" => "Category added successfully", "Category" => $category], 200);
    
        } catch (\Exception $e) {
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                return response()->json(["Result" => "Validation Error: " . $e->getMessage()], 400);
            } else {
                return response()->json(["Result" => "Error: " . $e->getMessage()], 500);
            }
        }
    }
    


    public function getAllcategories()
    {
        // Retrieve all orders with their related user and products
        $orders = categories-> all >get();

        // Return the response with all order[[s
        return response()->json(['orders' => [$orders]], 200);
    }

}

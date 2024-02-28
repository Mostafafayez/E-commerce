<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;

class products extends Controller
{
    public function add_product(Request $req, $num) {
        try {
            $req->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'image' =>'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
    
            $product = new Product;
    
            $product->price = $req->input('price');
            $product->name = $req->input('name'); // Changed from 'title' to 'name'
            $product->description = $req->input('description');
    
            if ($req->hasFile('image')) {
                $fileName = $req->file('image')->store('posts', 'public');
                $product->image = $fileName;
            }
    
            $product->category_id = $num;
    
            $product->save();
    
            // Return a more informative response
            return response()->json(["Result" => "Product uploaded successfully", "Product" => $product], 200);
        
        } catch (\Exception $e) {
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                return response()->json(["Result" => "Validation Error: " . $e->getMessage()], 400);
            } else {
                return response()->json(["Result" => "Error: " . $e->getMessage()], 500);
            }
        }}

        public function update_product(Request $req, $id) {
            try {
                $product = Product::findOrFail($id); // Find the product by ID
        
                // Validate only the fields that are present in the request
                $req->validate([
                    'name' => 'sometimes|string|max:255',
                    'description' => 'sometimes|string',
                    'price' => 'sometimes|numeric',
                    'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048'
                ]);
        
                // Update the product fields if they are present in the request
                if ($req->has('name')) {
                    $product->name = $req->input('name');
                }
                if ($req->has('description')) {
                    $product->description = $req->input('description');
                }
                if ($req->has('price')) {
                    $product->price = $req->input('price');
                }
                if ($req->hasFile('image')) {
                    $fileName = $req->file('image')->store('posts', 'public');
                    $product->image = $fileName;
                }
        
                $product->save();
        
                return response()->json(["Result" => "Product updated successfully", "Product" => $product], 200);
        
            } catch (\Exception $e) {
                return response()->json(["Result" => "Error: " . $e->getMessage()], 500);
            }



        }


        public function delete($id) {
            try {
                $product = Product::findOrFail($id);
                $product->delete();
                return response()->json(["Result" => "Product deleted successfully"], 200);
            } catch (\Exception $e) {
                return response()->json(["Result" => "Error: " . $e->getMessage()], 500);
            }
        }
        
        public function get_all() {
            try {
                $products = Product::all();
                return response()->json(["Result" => $products], 200);
            } catch (\Exception $e) {
                return response()->json(["Result" => "Error: " . $e->getMessage()], 500);
            }
        }
        
        public function get_by_id($id) {
            try {
                $product = Product::findOrFail($id);
                return response()->json(["Result" => $product], 200);
            } catch (\Exception $e) {
                return response()->json(["Result" => "Error: " . $e->getMessage()], 500);
            
            }}




            public function searchByName(Request $request)
            {
                // Validate the incoming request data
                $request->validate([
                    'name' => 'required|string|max:255',
                ]);
        
                // Retrieve products matching the provided name
                $products = Product::where('name', 'like', '%' . $request->input('name') . '%')->get();
        
                // Return the response with the matching products
                return response()->json(['products' => $products], 200);
            }



        



    }








    




















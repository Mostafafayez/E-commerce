<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use App\Models\product;
class products extends Controller
{
   

    public function add_product(Request $request, $num, $num2) {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric',
        'primary_image'=> 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
    
            $product = new Product;
    
            $product->price = $request->input('price');
            $product->name = $request->input('name');
            $product->description = $request->input('description');

         
            if ($request->hasFile('primary_image')) {
                $fileName = $request->file('primary_image')->store('posts', 'public');
                $product->primary_image = $fileName;
              
            }

            if ($request->hasFile('images')) {
           
                $filePaths = [];
                foreach ($request->file('images') as $image) {
                    $fileName = $image->store('posts', 'public');
                    // var_dump($image);
                    $filePaths[] = $fileName;
                }
                // Log the $filePaths array to check if it contains the correct file paths
        
                $product->images = $filePaths;
            }


    
            $product->category_id = $num;
            $product->user_id = $num2;
            $product->save();
    
            // Return a more informative response
            return response()->json(["Result" => "Product uploaded successfully", "Product" => $product], 200);
        
        } catch (\Exception $e) {
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                return response()->json(["Result" => "Validation Error: " . $e->getMessage()], 400);
            } else {
                return response()->json(["Result" => "Error: " . $e->getMessage()], 500);
            }
        }
    }
    

    // public function update_product(Request $req, $id, $imageIndex) {
    //     try {
    //         $product = Product::findOrFail($id); // Find the product by ID
    
    //         // Validate only the fields that are present in the request
    //         $req->validate([
    //             'name' => 'sometimes|string|max:255',
    //             'description' => 'sometimes|string',
    //             'price' => 'sometimes|numeric',
    //             'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
    //             'images.*' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         ]);
    
    //         // Update the product fields if they are present in the request
    //         if ($req->has('name')) {
    //             $product->name = $req->input('name');
    //         }
    //         if ($req->has('description')) {
    //             $product->description = $req->input('description');
    //         }
    //         if ($req->has('price')) {
    //             $product->price = $req->input('price');
    //         }
    //         if ($req->hasFile('image')) {
    //             $fileName = $req->file('image')->store('posts', 'public');
    //             $product->image = $fileName;
    //         }
    
    //         if ($request->hasFile('images')) {
    //             $filePaths = $product->images; // Get existing image paths
    //             $imageFiles = $request->file('images');


    //             if (isset($imageFiles[$imageIndex])) {
    //                 $fileName = $imageFiles[$imageIndex]->store('posts', 'public');
    //                 $filePaths[$imageIndex] = $fileName; // Update the specific image path
    //             }
    //             $product->images = $filePaths;
    //         }
    
    //         $product->save();
    
    //         return response()->json(["Result" => "Product updated successfully", "Product" => $product], 200);
    
    //     } catch (\Exception $e) {
    //         return response()->json(["Result" => "Error: " . $e->getMessage()], 500);
    //     }
    // }
    

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
                return response()->json($products, 200);
            } catch (\Exception $e) {
                return response()->json(["Result" => "Error: " . $e->getMessage()], 500);
            }
        }
        
        public function get_by_id($id) {
            try {
                $product = Product::findOrFail($id);
                return response()->json($product, 200); // Wrap $product in an array
            } catch (\Exception $e) {
                return response()->json(["Result" => "Error: " . $e->getMessage()], 500);
            }
        }

   public function get_by_categoryId($category_id) {
    try {
        // Find the product by category_id
        $product = Product::where('category_id', $category_id)->get();
        
        if ($product->isEmpty()) {
            return response()->json(["Result" => "No product found with category_id {$category_id}"], 404);
        }
        
        return response()->json($product, 200);
    } catch (\Exception $e) {
        return response()->json(["Result" => "Error: " . $e->getMessage()], 500);
    }



        }
        
        








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








    





















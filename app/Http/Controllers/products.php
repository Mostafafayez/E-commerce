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
                // 'discount' => 'required',
        'primary_image'=> 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'color' => 'required|array', // Ensure color is an array
        'color.*' => 'required|string',
        'size' => 'required|array', // Ensure color is an array
        'size.*' => 'required|string',
            ]);

            $product = new Product;

            $product->price = $request->input('price');
            $product->name = $request->input('name');
            $product->description = $request->input('description');
            $product->status = Product::STATUS_WAITING;


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
            $colors = $request->input('color');
            $product->color = $colors;


            $size = $request->input('size');
            $product->size = $size;


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





    public function update_product(Request $request, $product_id)
    {
        try {
            // Validate the fields present in the request
            $request->validate([
                'name' => 'string|max:255',
                'description' => 'string',
                'price' => 'numeric',
                'primary_image'=> 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'color' => 'array', // Ensure color is an array
                'color.*' => 'string',
                'size' => 'array', // Ensure size is an array
                'size.*' => 'string',

            ]);

            $product = Product::findOrFail($product_id);

            // Check if any fields are being updated
            $updated = false;

            // Update the product with the fields present in the request
            if ($request->has('name')) {
                $product->name = $request->input('name');
                $updated = true;
            }
            if ($request->has('description')) {
                $product->description = $request->input('description');
                $updated = true;
            }
            if ($request->has('price')) {
                $product->price = $request->input('price');
                $updated = true;
            }
            if ($request->hasFile('primary_image')) {
                $fileName = $request->file('primary_image')->store('posts', 'public');
                $product->primary_image = $fileName;
                $updated = true;
            }
            if ($request->hasFile('images')) {
                $filePaths = [];
                foreach ($request->file('images') as $image) {
                    $fileName = $image->store('posts', 'public');
                    $filePaths[] = $fileName;
                }
                $product->images = $filePaths;
                $updated = true;
            }
            if ($request->has('color')) {
                $product->color = $request->input('color');
                $updated = true;
            }
            if ($request->has('size')) {
                $product->size = $request->input('size');
                $updated = true;
            }

            // Save the updated product if any fields are updated
            if ($updated) {
                $product->save();
                return response()->json(["Result" => "Product updated successfully", "Product" => $product], 200);
            } else {
                return response()->json(["Result" => "No data to update"], 200);
            }

        } catch (\Exception $e) {
            if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                return response()->json(["Result" => "Product not found"], 404);
            } elseif ($e instanceof \Illuminate\Validation\ValidationException) {
                return response()->json(["Result" => "Validation Error: " . $e->getMessage()], 400);
            } else {
                return response()->json(["Result" => "Error: " . $e->getMessage()], 500);
            }
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

//    public function get_by_categoryId($category_id) {
//     try {
//         // Find the product by category_id
//         $product = Product::where('category_id', $category_id)
//         ->where('status', Product::STATUS_ACCEPTED)
//         ->get();

//         if ($product->isEmpty()) {
//             return response()->json(["Result" => "No product found with category_id {$category_id}"], 404);
//         }

//         return response()->json($product, 200);
//     } catch (\Exception $e) {
//         return response()->json(["Result" => "Error: " . $e->getMessage()], 500);
//     }




//         }




        public function get_by_categoryId($category_id) {
            try {
                // Find the product by category_id and status
                $products = Product::where('category_id', $category_id)
                    ->where('status', Product::STATUS_ACCEPTED)
                    ->get();

                if ($products->isEmpty()) {
                    return response()->json(["Result" => "No product found with category_id {$category_id}"], 404);
                }

                // Transform the data
                $transformedProducts = $products->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'description' => $product->description,
                        'full_src1' => $product->primary_image,
                        'images' => $product->images,
                        'color' => $product->color,
                        'size' => $product->size,
                        'price' => $product->price,
                        'user_id' => $product->user_id,
                        'category_id' => $product->category_id,
                        'discount' => $product->discount,
                        'new_price' => $product->new_price,
                        'status' => $product->status,
                        // 'full_src' => 'https://mo-ecommerce.hwnix.com/storage/' . $product->primary_image,
                        // 'full_src2' => [] // Assuming you want this to be an empty array
                    ];
                });

                return response()->json($transformedProducts, 200);
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
                return response()->json( $products, 200);
            }







    }






























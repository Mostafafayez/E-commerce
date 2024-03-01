<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
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


            if ($request->hasFile('image')) {
                $fileName = $request->file('image')->store('posts', 'public');
                $category->image = $fileName;
              
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
    




    public function getAllCategories() {
        try {
            $categories = Category::all();
            return response()->json($categories, 200);
        } catch (\Exception $e) {
            return response()->json(["Error: " . $e->getMessage()], 500);
        }
    }








}
//
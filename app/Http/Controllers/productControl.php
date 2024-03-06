<?php

namespace App\Http\Controllers;
use App\Models\product;
use Illuminate\Http\Request;

class productControl extends Controller
{
    public function approveProduct($productId) {
        $product = Product::find($productId);
        if ($product) {
            $product->status = Product::STATUS_ACCEPTED;
            $product->save();
            return response()->json(["Result" => "Product approved successfully"], 200);
        } else {
            return response()->json(["Result" => "Product not found"], 404);
        }
    }
    
    public function rejectProduct($productId) {
        $product = Product::find($productId);
        if ($product) {
            $product->status = Product::STATUS_REJECTED;
            $product->save();
            return response()->json(["Result" => "Product rejected successfully"], 200);
        } else {
            return response()->json(["Result" => "Product not found"], 404);
        }
    }
    
}

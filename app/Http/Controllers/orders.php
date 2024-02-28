<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;

class orders extends Controller
{
public function store(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
    ]);

    // Create a new order instance
    $order = new Order();
    $order->user_id = $request->input('user_id');
    $order->save();

    // Retrieve the product by its ID
    $product = Product::findOrFail($request->input('product_id'));

    // Attach the product to the order with the specified quantity
    $order->products()->attach($product->id, ['quantity' => $request->input('quantity')]);

    return response()->json(['message' => 'Order created successfully', 'order' => $order], 201);
}









    public function getAllOrders()
    {
        // Retrieve all orders with their related user and products
        $orders = Order::with('user', 'products')->get();

        // Return the response with all orders
        return response()->json(['orders' => $orders], 200);
    }


    public function getOrderById($id)
    {
        // Retrieve the order with the specified ID along with its related user and products
        $order = Order::with('user', 'products')->find($id);

        // Check if the order exists
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Return the response with the order
        return response()->json(['order' => $order], 200);
    }




    public function deleteOrderById($id)
    {
        // Find the order by its ID
        $order = Order::find($id);

        // Check if the order exists
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Delete the order
        $order->delete();

        // Return a success message
        return response()->json(['message' => 'Order deleted successfully'], 200);
    }










}








    


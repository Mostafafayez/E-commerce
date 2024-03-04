<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\users; 

use App\Models\OrderDetails;
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
        $order->quantity = $request->input('quantity');
        $order->save();
    
        // Create a new order detail instance
        $orderDetail = new OrderDetails();
        $orderDetail->order_id = $order->id;
        $orderDetail->product_id = $request->input('product_id');
        $orderDetail->save();
    
        return response()->json(['message' => 'Order created successfully', 'order' => $order], 201);
    }
    
    public function getAllOrders()
    {
        $orderData = []; // Initialize an empty array to store order data
    
        $orders = Order::all();
    
        foreach ($orders as $order) {
            $userData = []; // Initialize an empty array to store user data for each order
            $productData = []; // Initialize an empty array to store product data for each order
    
            // Retrieve the order data
            $orderDetails = [
                'order_id' => $order->id,
                // Add other columns from the Order table as needed
                'total_amount' => $order->total_amount,
                // Add more columns as needed
            ];
    
            // Retrieve the associated user data
            $user = $order->user;
    
            if ($user) {
                $userData = [
                    'user_id' => $user->id,
                    'name' => $user->name,
                    // Add other columns from the User table as needed
                    'email' => $user->email,
                    // Add more columns as needed
                ];
            }
    
            // Retrieve the associated product data
            $products = $order->product;
            // var_dump($products);
    
            foreach ($products as $products) {
                $productData[] = [
                    'product_id' => $products->id,
                    'name' => $products->name,
                
                    'price' => $products->price,
                   
                ];
            }
    
            // Combine order data, user data, and product data for the current order
            $orderData[] = [
                'order' => $orderDetails,
                'user' => $userData,
                 'products' => $productData,
              
            ];
        }
    
        return response()->json(['orders' => $orderData], 200);
    }
    





    
  
public function getOrderById()
{
    // Retrieve all orders with their related products and user
    $orders = Order::with(['products', 'user'])->get();

    // Check if any orders exist
    if ($orders->isEmpty()) {
        return response()->json(['message' => 'No orders found'], 404);
    }

    // Return the response with the orders and their related products and user
    return response()->json(['orders' => $orders], 200);
}
    



    public function deleteOrderById($id)
    {
        // Find the order by its ID
        $order =Order::find($id);

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








    


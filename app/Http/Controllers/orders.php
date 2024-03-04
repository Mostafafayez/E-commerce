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
            $userData = []; 
            $productData = []; 
    
          
            $orderDetails = [
                'order_id' => $order->id,
                'quantity' => $order->quantity,
               
            ];
    
            $user = $order->user;
    
            if ($user) {
                $userData = [
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'address' => $user->address,
                    'phone' => $user->phone,
                   
                ];
            }
    
            $products = $order->Product;

            // var_dump($products);
    
                if ($products) {
                $productData[] = [
                    'product_id' => $products->id,
                    'name' => $products->name,
                    'price' => $products->price,
                ];
            }
       
            $orderData[] = [
                'order' => $orderDetails,
                'user' => $userData,
                 'products' => $productData,
              
            ];
        }
    
        return response()->json(['orders' => $orderData], 200);
    }
    





    
  
    public function getOrderById($users_id)
    {
        // Initialize the array to store order data
        $orderData = [];
    
        // Retrieve orders for the specified user ID
        $orders = Order::where('users_id', $users_id)->get();
    
        // Loop through each order
        foreach ($orders as $order) {
            // Initialize arrays to store user and product data
            $userData = [];
            $productData = [];
    
            // Retrieve order details
            $orderDetails = [
                'order_id' => $order->id,
                'quantity' => $order->quantity,
            ];
    
            // Retrieve user details if available
            $user = $order->user;
            if ($user) {
                $userData = [
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'address' => $user->address,
                    'phone' => $user->phone,
                ];
            }
    
            // Retrieve products associated with the order
            $products = $order->product;
    
            
            if ($products) {
                $productData[] = [
                    'product_id' => $products->id,
                    'name' => $products->name,
                    'price' => $products->price,
                ];
            }
    
            // Store order, user, and product data in the orderData array
            $orderData[] = [
                'order' => $orderDetails,
                'user' => $userData,
                'products' => $productData,
            ];
        }
    
        // Check if no orders were found for the user
        if (empty($orderData)) {
            return response()->json(['message' => 'No orders found'], 404);
        }
    
        // Return JSON response with order data
        return response()->json(['orders' => $orderData], 200);
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








    


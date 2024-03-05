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
        // Validate the incoming request data
        $request->validate([
            'users_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric',
            'color' => 'required|string|max:255',
            'size' => 'required|string|max:255'

        ]);
    
        // Create a new order instance
        $order = new Order();
        
        // Assign user ID, product ID, and quantity to the order instance
        $order->users_id = $request->input('users_id'); // Corrected column name
        $order->product_id = $request->input('product_id');
        $order->quantity = $request->input('quantity');
        $order->price = $request->input('price');
        $order->color = $request->input('color');
        $order->size = $request->input('size');
    
        // Save the order to the database
        $order->save();
    
        // Return a JSON response indicating successful order creation
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
                'price'   =>  $order->price,
                'color'   =>  $order->color,
                'size'   =>  $order->size,

               
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
          
            $productData = [];
    
            // Retrieve order details
            $orderDetails = [
                'order_id' => $order->id,
                'quantity' => $order->quantity,
                'price'   =>  $order->price,
                'color'   =>  $order->color,
                'size'   =>  $order->size,
            ];
    
            // Retrieve user details if available
            // $user = $order->user;
            // if ($user) {
            //     $userData = [
            //         'user_id' => $user->id,
            //         'name' => $user->name,
            //         'address' => $user->address,
            //         'phone' => $user->phone,
            //     ];
            // }
    
            // Retrieve products associated with the order
            $products = $order->product;
    
            
            if ($products) {
                $productData= [
                    'product_id' => $products->id,
                    'name' => $products->name,
                    // 'price' => $products->price,
                ];
            }
    
            // Store order, user, and product data in the orderData array
            $orderData[]['order_details'] = [
                'order' => $orderDetails,
                // 'user' => $userData,
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








    


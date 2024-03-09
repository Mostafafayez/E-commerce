<?php

use App\Http\Controllers\orders;
use App\Http\Controllers\products;
use Illuminate\Http\Request;

use  App\Http\Controllers\login;
use  App\Http\Controllers\reset_password;
use  App\Http\Controllers\CategoryController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OffersController;
use App\Http\Controllers\productControl;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });




Route::post('/login', [login::class, 'login']);
Route::post('/Sign_up', [login::class, 'sign_up']);
Route::post('/updateuser/{id}', [login::class,'updateUserInfo']);
Route::get('/get', [login::class,'getusers']);

Route::post('/resetPassword', [reset_password::class, 'resetPassword']);
Route::get('/sendMessage', [reset_password::class, 'sendMessage']);


//admin

Route::post('/add_product/{category_id}/{user_id}', [products::class, 'add_product']);
// Route::post('/update_product/{id}/{index_image}', [products::class, 'update_product']);
Route::delete('/delete_product/{id}', [products::class, 'delete']);
Route::get('/getAll_products', [products::class, 'get_all']);
Route::get('/get_product/{id}', [products::class, 'get_by_id']);
Route::post('/search', [products::class, 'searchByName']);
Route::get('/get_products/{categoryId}', [products::class, 'get_by_categoryId']);
Route::post('/update_product/{Id}', [products::class,'update_product']);


//product_control
Route::get('/Approve_product/{Id}', [productControl::class,'approveProduct']);
Route::get('/Reject_Product/{Id}', [productControl::class,'rejectProduct']);








Route::post('/add_category', [CategoryController::class, 'add_category']);
Route::get('/get_category', [CategoryController::class, 'getAllcategories']);






Route::post('/add_order', [orders::class, 'store']);
Route::get('/getAllOrders', [orders::class, 'getAllOrders']);
Route::get('/get_order/{user_id}', [orders::class, 'getOrderById']);
Route::delete('/delete_order/{order_id}', [orders::class, 'deleteOrderById']);




Route::post('/add_offer', [OffersController::class,'store']);
Route::get('/get_offers', [OffersController::class, 'get_offers']);
Route::get('/get_offer/{id}', [OffersController::class , 'show']);
Route::delete('/delete_offer/{id}', [OffersController::class, 'destroy']);

Route::get('/test',function(){
    Artisan::call('storage:link');
 });

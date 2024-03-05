<?php

use App\Http\Controllers\orders;
use App\Http\Controllers\products;
use Illuminate\Http\Request;

use  App\Http\Controllers\login;
use  App\Http\Controllers\CategoryController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
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
Route::put('/updateUserInfo/{id}', [login::class, 'updateUserInfo']);


Route::post('/add_product/{category_id}/{user_id}', [products::class, 'add_product']);
Route::post('/update_product/{id}/{index_image}', [products::class, 'update_product']);
Route::delete('/delete_product/{id}', [products::class, 'delete']);
Route::get('/getAll_products', [products::class, 'get_all']);
Route::get('/get_product/{id}', [products::class, 'get_by_id']);
Route::post('/search', [products::class, 'searchByName']);
Route::get('/get_products/{categoryId}', [products::class, 'get_by_categoryId']);



Route::post('/add_category', [CategoryController::class, 'add_category']);
Route::get('/get_category', [CategoryController::class, 'getAllcategories']);






Route::post('/add_order', [orders::class, 'store']);
Route::get('/getAllOrders', [orders::class, 'getAllOrders']);
Route::get('/get_order/{user_id}', [orders::class, 'getOrderById']);
Route::delete('/delete_order/{order_id}', [orders::class, 'deleteOrderById']);
/// mostafa//
//mohamned??




Route::get('/test',function(){
    Artisan::call('storage:link');
 });
<?php

use App\Http\Controllers\orders;
use App\Http\Controllers\products;
use Illuminate\Http\Request;

use  App\Http\Controllers\login;
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

Route::post('/login', [Login::class, 'login']);
Route::put('/Sign_up', [Login::class, 'sign_up']);


Route::post('/add_product/{category_id}', [products::class, 'add_product']);
Route::post('/update_product/{id}', [products::class, 'update_product']);
Route::delete('/delete_product/{id}', [products::class, 'delete']);
Route::get('/getAll_products', [products::class, 'get_all']);
Route::get('/get_product/{id}', [products::class, 'get_by_id']);
Route::get('/search', [products::class, 'searchByName']);




Route::post('/add_order', [orders::class, 'store']);
Route::get('/getAllOrders', [orders::class, 'getAllOrders']);
Route::get('/get_order/{id}', [orders::class, 'getOrderById']);
Route::delete('/delete_order', [orders::class, 'deleteOrderById']);
/// mostafa//

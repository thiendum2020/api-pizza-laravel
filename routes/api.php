<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\BillController;
use App\Http\Controllers\Api\BillDetailController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// //User
// Route::apiResource('user', 'App\Http\Controllers\Api\UserController');

//download image
// Route::get('file/image', 'App\Http\Controllers\Api\FileController@downloadImage');
//update image
// Route::post('file/image', 'App\Http\Controllers\Api\FileController@updateImage');

// Login
Route::post('login', 'App\Http\Controllers\Api\LoginController@login');

/*---User---*/
Route::get('user', [UserController::class, 'index']);
Route::get('user/{id}', [UserController::class, 'show']);
Route::post('user', [UserController::class, 'store']);
Route::put('user/{id}', [UserController::class, 'update']);
Route::delete('user/{id}', [UserController::class, 'destroy']);

/*---Product---*/
Route::get('product', [ProductController::class, 'index']);
Route::get('product/type/{typeid}', [ProductController::class, 'getProductByTypeId']);
Route::get('product/{id}', [ProductController::class, 'show']);
Route::post('product', [ProductController::class, 'store']);
Route::put('product/{id}', [ProductController::class, 'update']);
Route::delete('product/{id}', [ProductController::class, 'destroy']);

//Type
Route::apiResource('type', 'App\Http\Controllers\Api\TypeController');

/*---Bill---*/
Route::get('bill', [BillController::class, 'index']);
Route::get('bill/user/{userid}', [BillController::class, 'getBillByUserId']);
Route::get('bill/note/{note}', [BillController::class, 'getBillByNote']);
Route::get('bill/{id}', [BillController::class, 'show']);
Route::post('bill', [BillController::class, 'store']);
Route::put('bill/{id}', [BillController::class, 'update']);
Route::delete('bill/{id}', [BillController::class, 'destroy']);
Route::delete('bill/delete/all', [BillController::class, 'deleteAll']);

/*---Bill-Detail---*/
// Route::get('product', [BillDetailController::class, 'index']);
Route::get('bill_detail/bill/{billid}', [BillDetailController::class, 'getDetailBillByBillId']);
Route::post('bill_detail', [BillDetailController::class, 'store']);
Route::put('bill_detail/{id}', [BillDetailController::class, 'update']);
Route::delete('bill_detail/{id}', [BillDetailController::class, 'destroy']);
Route::delete('bill_detail/delete/all', [BillDetailController::class, 'deleteAll']);
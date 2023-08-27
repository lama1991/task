<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// get all restaurants of a city
Route::get('restaurants-of-city/{id}',[CityController::class,'restaurantsOf']);

Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);
Route::get('logout',[AuthController::class,'logout'])->middleware('auth:sanctum');

Route::post('assign-roles',[UserController::class,'assignRoles'])->middleware(['auth:sanctum','admin']);
Route::post('update-roles',[UserController::class,'updateRoles'])->middleware(['auth:sanctum','admin']);

Route::group(['middleware' => ['auth:sanctum'],'prefix' => 'order'], function(){
    Route::post('create',[OrderController::class,'store']);
    Route::post('update/{id}',[OrderController::class,'update']);
    Route::get('user-orders',[OrderController::class,'userOrders']);
    });

Route::group(['prefix' => 'review'], function(){
Route::post('create',[ReviewController::class,'store'])->middleware(['auth:sanctum']);
});

Route::group(['prefix' => 'restaurant'], function(){
// user should be authenticated and have the role owner to create a restaurant
 Route::post('create',[RestaurantController::class,'store'])->middleware(['auth:sanctum','owner']);
 Route::get('menue/{id}',[RestaurantController::class,'menue']);
 Route::get('all',[RestaurantController::class,'index']);
 Route::get('show/{id}',[RestaurantController::class,'show']);
 Route::get('cuisine/{cuisine}',[RestaurantController::class,'cuisine']);
 Route::get('reviews/{id}',[RestaurantController::class,'reviews']);

 });

 Route::post('meal/create',[MealController::class,'store'])->middleware(['auth:sanctum','owner']);
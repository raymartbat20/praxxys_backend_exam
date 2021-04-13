<?php


use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;

Route::post('/login',[LoginController::class,'login']);

//Auth Routes
Route::middleware('auth:sanctum')->group(function(){
    Route::get('/check-token',[LoginController::class,'check_token']);
    Route::resource('product',ProductController::class);
});
Route::post('image-upload',[ProductController::class,'image_upload']);

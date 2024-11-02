<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\AdminController;
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

Route::group([
    //'middleware' => '',
    'prefix' => 'auth/admin'
    ],function(){
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/register', [AdminAuthController::class, 'register']);
    Route::post('/logout', [AdminAuthController::class, 'logout']);
    Route::post('/refresh', [AdminAuthController::class, 'refresh']);
    Route::get('/userProfile', [AdminAuthController::class, 'userProfile']);
    });



Route::group([
    //'middleware' => '',
    'prefix' => 'auth/user'
    ],function(){
    Route::post('/login', [UserAuthController::class, 'login']);
    Route::post('/register', [UserAuthController::class, 'register']);
    Route::post('/logout', [UserAuthController::class, 'logout']);
    Route::post('/refresh', [UserAuthController::class, 'refresh']);
    Route::get('/userProfile', [UserAuthController::class, 'userProfile']);
    Route::get('/verify/{token}', [UserAuthController::class, 'verify']);
    });    

Route::group([
    //'middleware' => '',
    'prefix' => 'admin/status'
    ],function(){
    Route::post('/changeStatus/{userId}', [AdminController::class, 'changeStatus'])->middleware('auth:admin');
    });    


    Route::get('/Unauthorized',function(){
        return response()->json(["Message" => "Unauthorized"], 401);
    })->name('login');
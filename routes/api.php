<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\GroupsController;

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

// Routes for Admin Authentication
Route::group([
    //'middleware' => '',
    'prefix' => 'auth/admin'
], function () {
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/register', [AdminAuthController::class, 'register']);
    Route::post('/logout', [AdminAuthController::class, 'logout']);
    Route::post('/refresh', [AdminAuthController::class, 'refresh']);
    Route::get('/userProfile', [AdminAuthController::class, 'userProfile']);
});

// Routes for User Authentication
Route::group([
    //'middleware' => '',
    'prefix' => 'auth/user'
], function () {
    Route::post('/login', [UserAuthController::class, 'login']);
    Route::post('/register', [UserAuthController::class, 'register']);
    Route::post('/logout', [UserAuthController::class, 'logout']);
    Route::post('/refresh', [UserAuthController::class, 'refresh']);
    Route::get('/userProfile', [UserAuthController::class, 'userProfile']);
    Route::get('/verify/{token}', [UserAuthController::class, 'verify']);
});

// Routes for Admin-specific actions
Route::group([
    //'middleware' => '',
    'prefix' => 'admin/status'
], function () {
    Route::post('/changeStatus/{userId}', [AdminController::class, 'changeStatus'])->middleware('auth:admin');
    Route::post('/showUserPending', [AdminController::class, 'showUserPending'])->middleware('auth:admin');
});

// Routes for Groups
Route::group([
    //'middleware' => '',
    'prefix' => 'user/group'
], function () {
    Route::post('/createGroup', [GroupsController::class, 'createGroup'])->middleware('auth:user');
    Route::post('/updateGroup/{id}', [GroupsController::class, 'updateGroup'])->middleware('auth:user');
    Route::get('/showGroup', [GroupsController::class, 'showGroup'])->middleware('checkUserType:admin,user');
});

// Routes for Files
Route::group([
    //'middleware' => '',
    'prefix' => 'files'
], function () {
    Route::get('/get', [FileController::class, 'get']);
    Route::post('/upload', [FileController::class, 'upload']);
    Route::post('/update/{file}', [FileController::class, 'update']);
    Route::delete('/delete/{file}', [FileController::class, 'destroy']);
});

// Unauthorized Route
Route::get('/Unauthorized', function () {
    return response()->json(["Message" => "Unauthorized"], 401);
})->name('login');

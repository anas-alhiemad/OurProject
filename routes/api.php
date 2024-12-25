<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\DisplayController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\InvitationController;



Route::group([
    'prefix' => 'auth/admin'
    ],function(){
    Route::post('/login', [AdminAuthController::class, 'login'])->middleware('attempts');
    Route::post('/register', [AdminAuthController::class, 'register']);
    Route::post('/logout', [AdminAuthController::class, 'logout']);
    Route::post('/refresh', [AdminAuthController::class, 'refresh']);
    Route::get('/userProfile', [AdminAuthController::class, 'userProfile']);
    });


    
    Route::group([
        'prefix' => 'auth/user'
        ],function(){
        Route::post('/login', [UserAuthController::class, 'login'])->middleware('transaction');
        Route::post('/register', [UserAuthController::class, 'register'])->middleware('transaction');
        Route::post('/logout', [UserAuthController::class, 'logout']);
        Route::post('/refresh', [UserAuthController::class, 'refresh']);
        Route::get('/userProfile', [UserAuthController::class, 'userProfile']);
        Route::post('/verify/{token}', [UserAuthController::class, 'verify'])->middleware('transaction');
        });

    Route::group([
        'prefix' => 'admin/status'
        ],function(){
        Route::post('/changeStatus/{userId}', [AdminController::class, 'changeStatus'])->middleware('auth:admin','transaction');
        Route::get('/showUserPending', [AdminController::class, 'showUserPending'])->middleware('auth:admin');
        });


    Route::group([
        'prefix' => 'user/group',
        'middleware' => 'auth:user,admin'
        ],function(){
        Route::post('/createGroup', [GroupsController::class, 'createGroup'])->middleware('auth:user','transaction');
        Route::post('/updateGroup/{id}', [GroupsController::class, 'updateGroup'])->middleware('auth:user','transaction');
        Route::post('/deleteGroup/{id}', [GroupsController::class, 'deleteGroup'])->middleware('auth:user','transaction');
        Route::get('/showGroup', [GroupsController::class, 'showGroup'])->middleware('checkUserType:admin,user');
        Route::get('/usersNotInGroup/{groupId}', [GroupsController::class, 'usersNotInGroup']);
        Route::get('/usersInGroup/{groupId}', [GroupsController::class, 'usersInGroup']);
        });



    Route::group([
        'prefix' => 'user/invitation',
        'middleware' => 'auth:user,admin'
        ],function(){
        Route::post('/sendinvitation/{userInvitedId}/{GroupId}', [InvitationController::class, 'sendInvitation'])->middleware('transaction');
        Route::post('/cancelinvitation/{InvitationId}', [InvitationController::class, 'cancelInvitation'])->middleware('transaction');    
        Route::get('/indexinvitation', [InvitationController::class, 'indexInvitation']);    
        Route::get('/invitationuserSpecific', [InvitationController::class, 'invitationUserSpecific']);    
        Route::get('/invitationgroupSpecific/{groupId}', [InvitationController::class, 'invitationGroupSpecific']);    
        Route::post('/acceptInvitation/{InvitationId}', [InvitationController::class, 'acceptInvitation'])->middleware('transaction');    
        Route::post('/declineInvitation/{InvitationId}', [InvitationController::class, 'declineInvitation'])->middleware('transaction');    
        });




    Route::group([
        'prefix' => 'display'
        ],function(){
        Route::get('/show', [DisplayController::class, 'index']);
        });



        // Route::middleware(['checkUserType:admin,user'])->group(function () {
        //     Route::get('/showGroup', [GroupsController::class, 'showGroup']);
        // });



        // Routes for Files
        Route::group([
            //'middleware' => '',
            'prefix' => 'files'
        ], function () {
            Route::get('/get', [FileController::class, 'get']);
            Route::post('/upload', [FileController::class, 'upload']);
            Route::post('/update/{file}', [FileController::class, 'update']);
            Route::delete('/delete/{file}', [FileController::class, 'destroy']);


            Route::post('/checkIn', [FileController::class, 'checkIn']);

            Route::post('/checkOut', [FileController::class, 'checkOut']);
        });

        Route::post('/checkOut', [FileController::class, 'checkOut']);
        Route::post('/excel/{file}', action: [FileController::class, 'exportOperations']);





















        Route::get('/Unauthorized',function(){
            return response()->json(["Message" => "Unauthorized"], 401);
        })->name('login');
        

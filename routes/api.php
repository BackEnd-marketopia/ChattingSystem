<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ChatController;
use App\Http\Controllers\API\PackageController;

Route::middleware([
    \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
    'throttle:api',
])->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});


Route::middleware('auth:sanctum')->group(function() {
    
    Route::post('/chats', [ChatController::class, 'createChat'])->middleware('role:admin');
    Route::get('/chats', [ChatController::class, 'getUserChats']);
    Route::post('/chats/{chatId}/messages', [ChatController::class, 'sendMessage']);
    Route::post('/chats/{chatId}/assign-team', [ChatController::class, 'assignTeam'])->middleware('role:admin');
    Route::post('/chats/{chatId}/attach-package', [ChatController::class, 'attachPackage'])->middleware('role:admin');


    Route::post('/packages', [PackageController::class, 'create'])->middleware('role:admin,team');
    Route::post('/packages/{packageId}/items', [PackageController::class, 'addItem'])->middleware('role:admin,team');
    Route::patch('/items/{itemId}/status', [PackageController::class, 'updateItemStatus'])->middleware('role:client');
    Route::get('/my-items', [PackageController::class, 'myItems'])->middleware('role:client');


});





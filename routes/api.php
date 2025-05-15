<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BonusItemController;
use App\Http\Controllers\API\ChatController;
use App\Http\Controllers\Api\ChatMessageController;
use App\Http\Controllers\API\ClientLimitController;
use App\Http\Controllers\API\PackageController;
use App\Http\Controllers\Api\ClientPackageController;
use App\Http\Controllers\API\ItemStatusHistoryController;
use App\Http\Controllers\Api\PackageAllowedItemController;
use App\Http\Controllers\Api\PackageItemController;
use App\Http\Controllers\Api\ItemUsageLogController;
use App\Http\Controllers\Api\ClientPackageItemController;
use App\Http\Controllers\API\ItemTypeController;

//step 1
Route::middleware([
    \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
    'throttle:60,1',
])->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register')->middleware(['auth:sanctum', 'role:admin']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});



Route::middleware('auth:sanctum')->group(function () {

    //Chats
    //step 3
    Route::post('/chats', [ChatController::class, 'createChat'])->name('chat')->middleware('role:admin');

    //step none
    Route::delete('/chats/{chatId}', [ChatController::class, 'deleteChat'])->name('deletechat')->middleware('role:admin');

    //step 3
    Route::get('/chats', [ChatController::class, 'getUserChats'])->name('getchats');

    //step none
    Route::get('/chats/{chatId}', [ChatController::class, 'getUserChat'])->name('getchat');


    //Messages

    //step 7  (store)
    Route::post('/chats/{chatId}/messages', [ChatMessageController::class, 'sendMessage'])->name('sendmessage');

    //step 8  (index)
    Route::get('/chats/{chatId}/messages', [ChatMessageController::class, 'getMessages'])->name('getmessages');


    //Team
    //step 4
    Route::post('/chats/{chatId}/assign-team', [ChatController::class, 'assignTeam'])->name('assignteam')->middleware('role:admin');


    //step 6
    //Package - Chat
    Route::post('/chats/{chatId}/attach-package', [ChatController::class, 'attachPackage'])->name('attachpackage')->middleware('role:admin');




    // Package Routes

    Route::prefix('packages')->group(function () {
        Route::get('/', [PackageController::class, 'index'])->name('packages.index')->middleware('role:admin|team');
        Route::get('/{packageId}', [PackageController::class, 'show'])->name('packages.show')->middleware('role:admin|team');
        Route::post('/', [PackageController::class, 'store'])->name('packages.store')->middleware('role:admin');
        Route::patch('/{packageId}', [PackageController::class, 'update'])->name('packages.update')->middleware('role:admin');
        Route::delete('/{packageId}', [PackageController::class, 'destroy'])->name('packages.destroy')->middleware('role:admin');
    });


    Route::prefix('package-items')->group(function () {
        Route::get('/{packageId}', [PackageItemController::class, 'index'])->name('package-items.index')->middleware('role:admin|team');
        Route::post('/', [PackageItemController::class, 'store'])->name('package-items.store')->middleware('role:admin');
        Route::get('/item/{id}', [PackageItemController::class, 'show'])->name('package-items.show')->middleware('role:admin|team');
        Route::put('/{id}', [PackageItemController::class, 'update'])->name('package-items.update')->middleware('role:admin');
        Route::delete('/{id}', [PackageItemController::class, 'destroy'])->name('package-items.destroy')->middleware('role:admin');
    });


    Route::prefix('item-types')->group(function () {
        Route::get('/', [ItemTypeController::class, 'index']);
        Route::post('/', [ItemTypeController::class, 'store']);
        Route::get('/{id}', [ItemTypeController::class, 'show']);
        Route::put('/{id}', [ItemTypeController::class, 'update']);
        Route::delete('/{id}', [ItemTypeController::class, 'destroy']);
    });


    Route::prefix('package-allowed-items')->group(function () {
        Route::get('/', [PackageAllowedItemController::class, 'index']);
        Route::get('/{id}', [PackageAllowedItemController::class, 'show']);
        Route::post('/', [PackageAllowedItemController::class, 'store']);
        Route::put('/{id}', [PackageAllowedItemController::class, 'update']);
        Route::delete('/{id}', [PackageAllowedItemController::class, 'destroy']);
        Route::get('/by-package/{packageId}', [PackageAllowedItemController::class, 'byPackage']);
    });


    ////////////////////////////////////////////////////////////////////////////////////////////


    Route::prefix('client-package')->group(function () {
        Route::post('log-usage', [ClientPackageController::class, 'logUsage']);
        Route::post('change-status', [ClientPackageController::class, 'changeStatus']);
        Route::get('/', [ClientPackageController::class, 'index']);
        Route::get('{clientPackageId}', [ClientPackageController::class, 'show']);
        Route::post('/', [ClientPackageController::class, 'store']);
        Route::patch('{clientPackageId}', [ClientPackageController::class, 'update']);
        Route::delete('{clientPackageId}', [ClientPackageController::class, 'destroy']);
    });


    Route::prefix('client-package-items')->group(function () {
        Route::put('{id}/edit', [ClientPackageItemController::class, 'editItem']);
        Route::put('{id}/decline', [ClientPackageItemController::class, 'declineItem']);
        Route::put('{id}/accept', [ClientPackageItemController::class, 'acceptItem']);
    });


    Route::prefix('client-limits')->group(function () {
        Route::get('/{clientPackageId}', [ClientLimitController::class, 'remainingLimits']);
        Route::post('/{clientPackageId}/decrement-edit', [ClientLimitController::class, 'decrementEdit']);
        Route::post('/{clientPackageId}/decrement-decline', [ClientLimitController::class, 'decrementDecline']);
    });


    /////////////////////////////////////////////////////////////////////////////////////


    Route::prefix('package-bonus-items')->group(function () {
        Route::get('bonus-items/{clientPackageId}', [BonusItemController::class, 'index']);
        Route::post('bonus-items', [BonusItemController::class, 'store']);
        Route::get('bonus-item/{id}', [BonusItemController::class, 'show']);
        Route::put('bonus-item/{id}', [BonusItemController::class, 'update']);
        Route::delete('bonus-item/{id}', [BonusItemController::class, 'destroy']);
        Route::post('bonus-items/{id}/deliver', [BonusItemController::class, 'deliver']);
    });


    Route::prefix('item-usage-logs')->group(function () {
        Route::get('/', [ItemUsageLogController::class, 'index']);
        Route::get('/{id}', [ItemUsageLogController::class, 'show']);
        Route::post('/', [ItemUsageLogController::class, 'store']);
        Route::put('/{id}', [ItemUsageLogController::class, 'update']);
        Route::delete('/{id}', [ItemUsageLogController::class, 'destroy']);
        Route::get('/by-client-package/{clientPackageId}', [ItemUsageLogController::class, 'byClientPackage']);
    });

    Route::prefix('item-status-histories')->group(function () {
        Route::post('/', [ItemStatusHistoryController::class, 'store']);
        Route::get('/{id}', [ItemStatusHistoryController::class, 'show']);
        Route::put('/{id}', [ItemStatusHistoryController::class, 'update']);
        Route::delete('/{id}', [ItemStatusHistoryController::class, 'destroy']);
        Route::get('/item/{itemId}', [ItemStatusHistoryController::class, 'indexByItem']);
    });
});

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

    //User
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/users', [AuthController::class, 'users'])->name('users')->middleware('role:admin');
    Route::get('/user/{id}', [AuthController::class, 'show'])->name('user.show')->middleware('role:admin');
    Route::put('/user/{id}', [AuthController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [AuthController::class, 'destroy'])->name('user.destroy')->middleware('role:admin');


    //Chats
    Route::post('/chats', [ChatController::class, 'createChat'])->name('chat')->middleware('role:admin');
    Route::delete('/chats/{chatId}', [ChatController::class, 'deleteChat'])->name('deletechat')->middleware('role:admin');
    Route::get('/chats', [ChatController::class, 'getUserChats'])->name('getchats');
    Route::get('/chats/{chatId}', [ChatController::class, 'getUserChat'])->name('getchat');


    //Messages
    Route::post('/chats/{chatId}/messages', [ChatMessageController::class, 'sendMessage'])->name('sendmessage');
    Route::get('/chats/{chatId}/messages', [ChatMessageController::class, 'getMessages'])->name('getmessages');


    //Team
    Route::post('/chats/{chatId}/assign-team', [ChatController::class, 'assignTeam'])->name('assignteam')->middleware('role:admin');


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


    //Package Items
    Route::prefix('package-items')->group(function () {
        Route::get('/{packageId}', [PackageItemController::class, 'index'])->name('package-items.index')->middleware('role:admin|team');
        Route::post('/', [PackageItemController::class, 'store'])->name('package-items.store')->middleware('role:admin');
        Route::get('/item/{id}', [PackageItemController::class, 'show'])->name('package-items.show')->middleware('role:admin|team');
        Route::put('/{id}', [PackageItemController::class, 'update'])->name('package-items.update')->middleware('role:admin');
        Route::delete('/{id}', [PackageItemController::class, 'destroy'])->name('package-items.destroy')->middleware('role:admin');
    });


    //Item Types
    Route::prefix('item-types')->group(function () {
        Route::get('/', [ItemTypeController::class, 'index'])->name('item-types.index')->middleware('role:admin|team');
        Route::post('/create', [ItemTypeController::class, 'store'])->name('item-types.store')->middleware('role:admin');
        Route::get('/{id}', [ItemTypeController::class, 'show'])->name('item-types.show')->middleware('role:admin|team');
        Route::put('/{id}', [ItemTypeController::class, 'update'])->name('item-types.update')->middleware('role:admin');
        Route::delete('/{id}', [ItemTypeController::class, 'destroy'])->name('item-types.destroy')->middleware('role:admin');
    });


    //Package Allowed Items
    Route::prefix('package-allowed-items')->group(function () {
        Route::get('/', [PackageAllowedItemController::class, 'index'])->name('package-allowed-items.index')->middleware('role:admin|team');
        Route::get('/{id}', [PackageAllowedItemController::class, 'show'])->name('package-allowed-items.show')->middleware('role:admin|team');
        Route::post('/store', [PackageAllowedItemController::class, 'store'])->name('package-allowed-items.store')->middleware('role:admin');
        Route::put('/{id}', [PackageAllowedItemController::class, 'update'])->name('package-allowed-items.update')->middleware('role:admin');
        Route::delete('/{id}', [PackageAllowedItemController::class, 'destroy'])->name('package-allowed-items.destroy')->middleware('role:admin');
    });


    ////////////////////////////////////////////////////////////////////////////////////////////

    //Client Package
    Route::prefix('client-package')->group(function () {
        // Route::post('/log-usage', [ClientPackageController::class, 'logUsage'])->name('client-package.log-usage')->middleware('role:admin');
        // Route::post('/change-status', [ClientPackageController::class, 'changeStatus'])->name('client-package.change-status')->middleware('role:admin');
        Route::get('/', [ClientPackageController::class, 'index'])->name('client-package.index')->middleware('role:admin');
        Route::get('/{clientPackageId}', [ClientPackageController::class, 'show'])->name('client-package.show')->middleware('role:admin');
        Route::post('/', [ClientPackageController::class, 'store'])->name('client-package.store')->middleware('role:admin');
        Route::patch('/{clientPackageId}', [ClientPackageController::class, 'update'])->name('client-package.update')->middleware('role:admin');
        Route::delete('/{clientPackageId}', [ClientPackageController::class, 'destroy'])->name('client-package.destroy')->middleware('role:admin');
    });

    //Client Package Items
    Route::prefix('client-package-items')->group(function () {
        Route::get('/{clientPackageId}', [ClientPackageItemController::class, 'index'])->name('client-package-items.index')->middleware('role:admin');
        Route::get('/{clientPackageId}/{id}', [ClientPackageItemController::class, 'show'])->name('client-package-items.show')->middleware('role:admin');
        Route::post('/store/{clientPackageId}', [ClientPackageItemController::class, 'store'])->name('client-package-items.store')->middleware('role:admin|team');
        Route::patch('/{clientPackageId}/{id}', [ClientPackageItemController::class, 'update'])->name('client-package-items.update')->middleware('role:admin|team');
        Route::delete('/{clientPackageId}/{id}', [ClientPackageItemController::class, 'destroy'])->name('client-package-items.destroy')->middleware('role:admin');
        Route::put('{id}/accept', [ClientPackageItemController::class, 'accept'])->name('client-package-items.accept')->middleware('role:client');
        Route::put('{id}/edit', [ClientPackageItemController::class, 'edit'])->name('client-package-items.edit')->middleware('role:client');
        Route::put('{id}/decline', [ClientPackageItemController::class, 'decline'])->name('client-package-items.decline')->middleware('role:client');
    });


    //Client Limits
    Route::prefix('client-limits')->group(function () {
        Route::get('/', [ClientLimitController::class, 'index'])->name('client-limits.index')->middleware('role:admin|team');
        Route::post('/store', [ClientLimitController::class, 'store'])->name('client-limits.store')->middleware('role:admin');
        Route::put('edit/{id}', [ClientLimitController::class, 'update'])->name('client-limits.update')->middleware('role:admin');
        Route::delete('/{id}', [ClientLimitController::class, 'destroy'])->name('client-limits.destroy')->middleware('role:admin');

        Route::get('/{clientPackageId}', [ClientLimitController::class, 'remainingLimits'])->name('client-limits.remainingLimits')->middleware('role:admin|team|client');
        Route::post('/{clientPackageId}/decrement-edit', [ClientLimitController::class, 'decrementEdit'])->name('client-limits.decrementEdit')->middleware('role:admin|client');
        Route::post('/{clientPackageId}/decrement-decline', [ClientLimitController::class, 'decrementDecline'])->name('client-limits.decrementDecline')->middleware('role:admin|client');
    });


    /////////////////////////////////////////////////////////////////////////////////////

    //Bonus Items
    Route::prefix('package-bonus-items')->group(function () {
        Route::get('bonus-items/{clientPackageId}', [BonusItemController::class, 'index'])->name('package-bonus-items.index')->middleware('role:admin|team');
        Route::post('bonus-items', [BonusItemController::class, 'store'])->name('package-bonus-items.store')->middleware('role:admin');
        Route::get('bonus-item/{id}', [BonusItemController::class, 'show'])->name('package-bonus-items.show')->middleware('role:admin|team');
        Route::put('bonus-item/edit/{id}', [BonusItemController::class, 'update'])->name('package-bonus-items.update')->middleware('role:admin');
        Route::delete('bonus-item/{id}', [BonusItemController::class, 'destroy'])->name('package-bonus-items.destroy')->middleware('role:admin');
        Route::post('bonus-items/{id}/deliver', [BonusItemController::class, 'deliver'])->name('package-bonus-items.deliver')->middleware('role:admin|team');
    });


    //Item Usage Logs
    Route::prefix('item-usage-logs')->group(function () {
        Route::get('/', [ItemUsageLogController::class, 'index'])->name('item-usage-logs.index')->middleware('role:admin|team');
        Route::get('/{id}', [ItemUsageLogController::class, 'show'])->name('item-usage-logs.show')->middleware('role:admin|team');
        Route::post('/create', [ItemUsageLogController::class, 'store'])->name('item-usage-logs.store')->middleware('role:admin');
        Route::put('/{id}', [ItemUsageLogController::class, 'update'])->name('item-usage-logs.update')->middleware('role:admin');
        Route::delete('/{id}', [ItemUsageLogController::class, 'destroy'])->name('item-usage-logs.destroy')->middleware('role:admin');
        Route::get('/by-client-package/{clientPackageId}', [ItemUsageLogController::class, 'byClientPackage'])->name('item-usage-logs.byClientPackage')->middleware('role:admin|team');
    });

    //Item Status Histories
    Route::prefix('item-status-histories')->group(function () {
        Route::post('/', [ItemStatusHistoryController::class, 'store'])->name('item-status-histories.store')->middleware('role:admin');
        Route::get('/{id}', [ItemStatusHistoryController::class, 'show'])->name('item-status-histories.show')->middleware('role:admin|team');
        Route::put('edit/{id}', [ItemStatusHistoryController::class, 'update'])->name('item-status-histories.update')->middleware('role:admin');
        Route::delete('/{id}', [ItemStatusHistoryController::class, 'destroy'])->name('item-status-histories.destroy')->middleware('role:admin');
        Route::get('/item/{itemId}', [ItemStatusHistoryController::class, 'indexByItem'])->name('item-status-histories.indexByItem')->middleware('role:admin|team');
    });
});

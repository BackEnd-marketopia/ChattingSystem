<?php

namespace App\Providers;

use App\Http\Controllers\API\ChatController;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Spatie\Permission\Middleware\RoleMiddleware;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Route::aliasMiddleware('role', RoleMiddleware::class);

        Route::middleware('api')
            ->prefix('api')
            ->group(function () {
                Route::middleware([
                    EnsureFrontendRequestsAreStateful::class,
                    'throttle:api',
                ])->group(base_path('routes/api.php'));
            });
    }
}

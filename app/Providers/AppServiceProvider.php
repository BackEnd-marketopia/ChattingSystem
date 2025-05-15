<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Auth\AuthRepositoryInterface;
use App\Repositories\Auth\AuthRepository;
use App\Repositories\Chat\ChatRepositoryInterface;
use App\Repositories\Chat\ChatRepository;
use App\Repositories\ChatMessage\ChatMessageRepositoryInterface;
use App\Repositories\ChatMessage\ChatMessageRepository;
use App\Repositories\ClientPackage\ClientPackageInterface;
use App\Repositories\ClientPackage\ClientPackageRepository;
use App\Repositories\ClientPackageItem\ClientPackageItemRepositoryInterface;
use App\Repositories\ClientPackageItem\ClientPackageItemRepository;
use App\Repositories\PackageItem\PackageItemRepositoryInterface;
use App\Repositories\Package\PackageRepository;
use App\Repositories\Package\PackageRepositoryInterface;
use App\Repositories\PackageItem\PackageItemRepository;
use Illuminate\Support\Facades\Response;
use App\Repositories\ItemType\ItemTypeRepositoryInterface;
use App\Repositories\ItemType\ItemTypeRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(ChatRepositoryInterface::class, ChatRepository::class);
        $this->app->bind(ChatMessageRepositoryInterface::class, ChatMessageRepository::class);
        $this->app->bind(ClientPackageInterface::class, ClientPackageRepository::class);
        $this->app->bind(
            \App\Repositories\Interfaces\BonusItemRepositoryInterface::class,
            \App\Repositories\BonusItemRepository::class
        );
        $this->app->bind(PackageRepositoryInterface::class, PackageRepository::class);
        $this->app->bind(ClientPackageItemRepositoryInterface::class, ClientPackageItemRepository::class);
        $this->app->bind(PackageItemRepositoryInterface::class, PackageItemRepository::class);
        $this->app->bind(ItemTypeRepositoryInterface::class, ItemTypeRepository::class);



        $this->app->singleton('files', function ($app) {
            return new \Illuminate\Filesystem\Filesystem;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Response::macro(
            'api',
            function ($message, $statusCode = 200, $status = true, $errorNum = null, $data = null) {
                $responseData = [
                    'status' => $status,
                    'errorNum' => $errorNum,
                    'message' => $message,
                ];

                if ($data)
                    $responseData = array_merge($responseData, ['data' => $data]);

                return response()->json($responseData, $statusCode);
            }
        );
    }
}

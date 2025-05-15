<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (Throwable $e, $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                if ($e instanceof ValidationException) {
                    return Response::api($e->getMessage(), 422, false, 422);
                }

                if ($e instanceof AuthenticationException) {
                    return Response::api($e->getMessage(), 403, false, 403);
                }

                // if ($e instanceof HttpException) {
                //     return Response::api($e->getMessage(), $e->getStatusCode(), false, $e->getStatusCode());
                // }

                // if ($e instanceof ModelNotFoundException) {
                //     $model = strtolower(class_basename($e->getModel()));
                //     return Response::api("{$model} not found", 404, false, 404);
                // }

                // if ($e instanceof NotFoundHttpException) {
                //     return Response::api('Resource not found', 404, false, 404);
                // }


                // return Response::api($e->getMessage(), 500, false, 500);
            }
        });
    })->create();

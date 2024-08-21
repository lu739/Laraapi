<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'draft' => \App\Http\Middleware\DraftProduct::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $e) {
            if ( $e instanceof \Illuminate\Auth\AuthenticationException) {
                return responseFailed(401, __('exceptions.no_auth'));
                if ( $e->getPrevious() instanceof \Illuminate\Auth\Access\AuthorizationException ) {
                    return '1111111';
            //         return redirect()
            //             ->route('dashboard')
            //             ->withErrors($e->getMessage());
                }
            }

            if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
                if ($e->getPrevious() instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                    return responseFailed(404, __('exceptions.model_not_found'));
                }
                return responseFailed(404, __('exceptions.route_not_found'));
            }
            if ($e instanceof \App\Services\Product\Exceptions\ProductNotFoundException) {
                return responseFailed(404, __('exceptions.product_not_found'));
            }
        });
    })->create();

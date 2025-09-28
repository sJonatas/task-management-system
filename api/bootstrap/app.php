<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        if (request()->is('api/*')) {
            $exceptions->render(function (Exception $exception, \Illuminate\Http\Request $request) {
                $code = ! empty($exception->getCode())
                    ? $exception->getCode()
                    : 500;

                $response = [
                    'error' => $exception->getMessage(),
                    'status' => $code,
                ];

                return response()->json($response, $code);
            });
        }
    })->create();

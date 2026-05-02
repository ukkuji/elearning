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
        apiPrefix: '',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'jwt' => \App\Http\Middleware\JwtMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Illuminate\Validation\ValidationException $exception, \Illuminate\Http\Request $request) {
            if ($request->expectsJson() || $request->is('auth/*') || $request->is('products*')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed.',
                    'errors' => $exception->errors(),
                ], 400);
            }
        });

        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $exception, \Illuminate\Http\Request $request) {
            if ($request->expectsJson() || $request->is('auth/*') || $request->is('products*') || $request->is('instructors/*') || $request->is('transactions/*')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Resource not found.',
                ], 404);
            }
        });

        $exceptions->render(function (\Throwable $exception, \Illuminate\Http\Request $request) {
            if ($request->expectsJson() || $request->is('auth/*') || $request->is('products*') || $request->is('instructors/*') || $request->is('transactions/*')) {
                $status = method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500;

                if ($status < 400 || $status > 599) {
                    $status = 500;
                }

                return response()->json([
                    'status' => 'error',
                    'message' => $status === 500 ? 'Internal Server Error' : $exception->getMessage(),
                ], $status);
            }
        });
    })->create();

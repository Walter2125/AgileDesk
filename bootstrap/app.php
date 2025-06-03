<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Handle 404 errors
        $exceptions->render(function (NotFoundHttpException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Page not found',
                    'error' => '404'
                ], 404);
            }
            
            return response()->view('errors.404', [], 404);
        });

        // Handle other HTTP exceptions
        $exceptions->render(function (HttpException $e, $request) {
            $statusCode = $e->getStatusCode();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $e->getMessage() ?: 'An error occurred',
                    'error' => $statusCode
                ], $statusCode);
            }

            // Check if custom error view exists
            if (view()->exists("errors.{$statusCode}")) {
                return response()->view("errors.{$statusCode}", [], $statusCode);
            }
            
            return null; // Let Laravel handle it by default
        });
    })->create();

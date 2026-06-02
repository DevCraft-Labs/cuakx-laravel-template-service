<?php

use Cuakx\Core\DTO\BaseResponseDTO;
use Cuakx\Core\Utils\Console;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\SubstituteBindings;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Enforce API middleware to prevent 419 error
        $middleware->api([
            'throttle:60,1',
            SubstituteBindings::class,
        ]);

        // Enforce no redirection on API routes
        $middleware->redirectTo(
            fn (Request $request) => $request->is('api/*') ? null : '/login'
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        // Catch unauthorized error first
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->is('api/*')) {
                return BaseResponseDTO::error("401", $e->getMessage());
            }
        });

        // Exception catchers
        $exceptions->render(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {
                // Error Response Knitting
                // Error [CODEEX] : Blablabla
                // To
                // Blablabla (CODEEX) -> ERROR CODE MUST CONSIST OF 6 CHARACTERS
                $error_code = "999";
                $message = $e->getMessage();

                if(str_starts_with($e->getMessage(), "Error [")){
                    $error_code = substr($e->getMessage(), 7, 6);
                    $message = substr($e->getMessage(), 17, strlen($message) - 1) . " ($error_code)";
                }

                Console::writeLine($e->getMessage(), 'e');

                return BaseResponseDTO::error($error_code, $message);
            }
        });

    })->create();

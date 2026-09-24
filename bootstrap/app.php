<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(\App\Http\Middleware\SecureHeaders::class);
        $middleware->validateCsrfTokens(except: [
            'api/*',
        ]);
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
            'force_password' => \App\Http\Middleware\ForcePasswordChange::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

// Auto-detect public path for cPanel shared hosting (public_html)
$basePath = dirname(__DIR__);
$cpanelPublic = null;

if (!empty($_ENV['PUBLIC_PATH']) && is_dir($_ENV['PUBLIC_PATH'])) {
    $cpanelPublic = $_ENV['PUBLIC_PATH'];
} elseif (!empty($_SERVER['DOCUMENT_ROOT']) && is_dir($_SERVER['DOCUMENT_ROOT']) && realpath($_SERVER['DOCUMENT_ROOT']) !== realpath($basePath)) {
    $cpanelPublic = realpath($_SERVER['DOCUMENT_ROOT']);
} elseif (is_dir($basePath . '/../public_html')) {
    $cpanelPublic = realpath($basePath . '/../public_html');
} elseif (is_dir($basePath . '/public_html')) {
    $cpanelPublic = realpath($basePath . '/public_html');
}

if ($cpanelPublic) {
    $app->usePublicPath($cpanelPublic);
}

return $app;

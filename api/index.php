<?php

// Forward static assets if accessed directly
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH));
if ($uri !== '/' && file_exists(__DIR__ . '/../public' . $uri)) {
    return false;
}

// Ensure temporary writable directories exist in Vercel's /tmp
$tmpStorage = '/tmp/storage';
$folders = [
    $tmpStorage . '/framework/views',
    $tmpStorage . '/framework/cache',
    $tmpStorage . '/framework/sessions',
    $tmpStorage . '/logs',
];

foreach ($folders as $folder) {
    if (!is_dir($folder)) {
        @mkdir($folder, 0755, true);
    }
}

// Redirect storage and cache environment path to /tmp
putenv('APP_CONFIG_CACHE=/tmp/config.php');
putenv('APP_EVENTS_CACHE=/tmp/events.php');
putenv('APP_PACKAGES_CACHE=/tmp/packages.php');
putenv('APP_ROUTES_CACHE=/tmp/routes.php');
putenv('APP_SERVICES_CACHE=/tmp/services.php');
putenv('VIEW_COMPILED_PATH=' . $tmpStorage . '/framework/views');

// Forward execution to standard Laravel entry point
require __DIR__ . '/../public/index.php';


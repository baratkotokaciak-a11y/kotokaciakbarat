<?php

// 1. Buat folder temporary di /tmp
$storageFolders = [
    '/tmp/storage/app/public',
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
    '/tmp/bootstrap/cache',
    '/tmp/database',
];

foreach ($storageFolders as $folder) {
    if (!is_dir($folder)) {
        mkdir($folder, 0755, true);
    }
}

// 2. Salin database.sqlite dari repositori ke /tmp/database/
$sourceSqlite = __DIR__ . '/../database/database.sqlite';
$targetSqlite = '/tmp/database/database.sqlite';

if (file_exists($sourceSqlite)) {
    copy($sourceSqlite, $targetSqlite);
} else {
    touch($targetSqlite);
}

// 3. Paksa Laravel menggunakan database dari /tmp
putenv("DB_DATABASE={$targetSqlite}");
$_ENV['DB_DATABASE'] = $targetSqlite;

putenv('VIEW_COMPILED_PATH=/tmp/storage/framework/views');
$_ENV['VIEW_COMPILED_PATH'] = '/tmp/storage/framework/views';

putenv('APP_SERVICES_CACHE=/tmp/bootstrap/cache/services.php');
$_ENV['APP_SERVICES_CACHE'] = '/tmp/bootstrap/cache/services.php';

putenv('APP_PACKAGES_CACHE=/tmp/bootstrap/cache/packages.php');
$_ENV['APP_PACKAGES_CACHE'] = '/tmp/bootstrap/cache/packages.php';

putenv('APP_CONFIG_CACHE=/tmp/bootstrap/cache/config.php');
$_ENV['APP_CONFIG_CACHE'] = '/tmp/bootstrap/cache/config.php';

putenv('APP_ROUTES_CACHE=/tmp/bootstrap/cache/routes.php');
$_ENV['APP_ROUTES_CACHE'] = '/tmp/bootstrap/cache/routes.php';

// 4. Bootstrapping Laravel
require __DIR__ . '/../public/index.php';
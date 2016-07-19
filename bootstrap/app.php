<?php

require __DIR__ . '/../vendor/autoload.php';

$db = require __DIR__ . '/../database/config.php';

$app = new \App\App();

$app['db'] = function () use ($db) {
    $pdo = null;
    $driver = $db['driver'];
    
    if ($driver == 'mysql') {
        $pdo = new PDO(
            'mysql:host=' . $db['host'] . ':' . $db['port'] . ';' . 'dbname=' . $db['database'],
            $db['username'],
            $db['password']
        );
    }

    return $pdo;
};

return $app;

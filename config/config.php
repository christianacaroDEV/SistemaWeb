<?php

return [
    'database' => [
        'host' => $_ENV['DB_HOST'] ?? 'localhost',
        'port' => $_ENV['DB_PORT'] ?? '3306',
        'database' => $_ENV['DB_NAME'] ?? 'sistema_web',
        'username' => $_ENV['DB_USER'] ?? 'root',
        'password' => $_ENV['DB_PASS'] ?? ''
    ],
    'app' => [
        'name' => 'Sistema Web',
        'version' => '1.0.0',
        'environment' => $_ENV['APP_ENV'] ?? 'development',
        'debug' => $_ENV['APP_DEBUG'] ?? true
    ],
    'session' => [
        'name' => 'SISTEMA_WEB_SESSION',
        'lifetime' => 3600, // 1 hora
        'secure' => false, // cambiar a true en producción con HTTPS
        'httponly' => true
    ]
];
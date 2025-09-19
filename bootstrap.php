<?php

require_once __DIR__ . '/autoload.php';

// Cargar variables de entorno desde .env si existe
if (file_exists(__DIR__ . '/.env')) {
    $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            [$key, $value] = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
}

// Cargar configuración
$config = require_once __DIR__ . '/config/config.php';

// Inicializar contenedor de dependencias
$container = new \SistemaWeb\Infrastructure\Container\DependencyContainer($config);

// Configurar sesiones
ini_set('session.name', $config['session']['name']);
ini_set('session.gc_maxlifetime', $config['session']['lifetime']);
ini_set('session.cookie_httponly', $config['session']['httponly']);
ini_set('session.cookie_secure', $config['session']['secure']);

// Configurar zona horaria
date_default_timezone_set('America/Bogota');

// Función helper para obtener servicios del contenedor
function app(string $service = null)
{
    global $container;
    
    if ($service === null) {
        return $container;
    }
    
    return $container->get($service);
}

return $container;
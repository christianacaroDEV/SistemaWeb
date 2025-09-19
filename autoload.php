<?php

// Autoloader simple para la aplicación
spl_autoload_register(function ($className) {
    // Convertir namespace a ruta de archivo
    $className = str_replace('SistemaWeb\\', '', $className);
    $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
    
    // Convertir a minúsculas para coincidir con la estructura de carpetas
    $parts = explode(DIRECTORY_SEPARATOR, $className);
    $file = __DIR__ . '/src/' . strtolower(implode(DIRECTORY_SEPARATOR, $parts)) . '.php';
    
    if (file_exists($file)) {
        require_once $file;
    }
});
<?php

require_once __DIR__ . '/bootstrap.php';

// Router simple
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Remover query string si existe
$path = parse_url($requestUri, PHP_URL_PATH);

// Obtener el controlador de autenticación
$authController = app(\SistemaWeb\Presentation\Controllers\AuthController::class);

// Definir rutas
switch ($path) {
    case '/':
        header('Location: /login');
        exit;
        
    case '/login':
        if ($requestMethod === 'GET') {
            $authController->showLoginForm();
        } elseif ($requestMethod === 'POST') {
            $authController->login();
        }
        break;
        
    case '/register':
        if ($requestMethod === 'GET') {
            $authController->showRegisterForm();
        } elseif ($requestMethod === 'POST') {
            $authController->register();
        }
        break;
        
    case '/logout':
        if ($requestMethod === 'POST') {
            $authController->logout();
        }
        break;
        
    case '/dashboard':
        if ($requestMethod === 'GET') {
            $authController->dashboard();
        }
        break;
        
    default:
        // Servir archivos estáticos
        if (preg_match('/\.(css|js|png|jpg|jpeg|gif|ico)$/', $path)) {
            $filePath = __DIR__ . '/public' . $path;
            if (file_exists($filePath)) {
                $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                $mimeTypes = [
                    'css' => 'text/css',
                    'js' => 'application/javascript',
                    'png' => 'image/png',
                    'jpg' => 'image/jpeg',
                    'jpeg' => 'image/jpeg',
                    'gif' => 'image/gif',
                    'ico' => 'image/x-icon'
                ];
                
                header('Content-Type: ' . ($mimeTypes[$extension] ?? 'application/octet-stream'));
                readfile($filePath);
                exit;
            }
        }
        
        // 404 Not Found
        http_response_code(404);
        echo '<h1>404 - Página no encontrada</h1>';
        break;
}
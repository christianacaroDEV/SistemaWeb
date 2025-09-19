<?php

namespace SistemaWeb\Presentation\Controllers;

use SistemaWeb\Application\UseCases\Auth\LoginUseCase;
use SistemaWeb\Application\UseCases\Auth\LoginRequest;
use SistemaWeb\Application\UseCases\Auth\RegisterUseCase;
use SistemaWeb\Application\UseCases\Auth\RegisterRequest;
use SistemaWeb\Domain\Exceptions\UserNotFoundException;
use InvalidArgumentException;

class AuthController
{
    private LoginUseCase $loginUseCase;
    private RegisterUseCase $registerUseCase;

    public function __construct(LoginUseCase $loginUseCase, RegisterUseCase $registerUseCase)
    {
        $this->loginUseCase = $loginUseCase;
        $this->registerUseCase = $registerUseCase;
    }

    public function showLoginForm(): void
    {
        session_start();
        
        // Si ya está autenticado, redirigir al dashboard
        if (isset($_SESSION['user_id'])) {
            header('Location: /dashboard');
            exit;
        }
        
        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function showRegisterForm(): void
    {
        session_start();
        
        // Si ya está autenticado, redirigir al dashboard
        if (isset($_SESSION['user_id'])) {
            header('Location: /dashboard');
            exit;
        }
        
        require_once __DIR__ . '/../views/auth/register.php';
    }

    public function login(): void
    {
        session_start();
        
        try {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $request = new LoginRequest($email, $password);
            $response = $this->loginUseCase->execute($request);

            if ($response->isSuccess()) {
                $userData = $response->getUserData();
                $_SESSION['user_id'] = $userData['id'];
                $_SESSION['user_email'] = $userData['email'];
                $_SESSION['user_name'] = $userData['name'];
                
                $this->jsonResponse($response->toArray());
            } else {
                $this->jsonResponse($response->toArray(), 400);
            }
        } catch (UserNotFoundException | InvalidArgumentException $e) {
            $this->jsonResponse([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        } catch (\Exception $e) {
            $this->jsonResponse([
                'success' => false,
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }

    public function register(): void
    {
        session_start();
        
        try {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $name = $_POST['name'] ?? '';

            $request = new RegisterRequest($email, $password, $name);
            $response = $this->registerUseCase->execute($request);

            if ($response->isSuccess()) {
                $userData = $response->getUserData();
                $_SESSION['user_id'] = $userData['id'];
                $_SESSION['user_email'] = $userData['email'];
                $_SESSION['user_name'] = $userData['name'];
                
                $this->jsonResponse($response->toArray());
            } else {
                $this->jsonResponse($response->toArray(), 400);
            }
        } catch (InvalidArgumentException $e) {
            $this->jsonResponse([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        } catch (\Exception $e) {
            $this->jsonResponse([
                'success' => false,
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }

    public function logout(): void
    {
        session_start();
        session_destroy();
        
        $this->jsonResponse([
            'success' => true,
            'message' => 'Sesión cerrada exitosamente'
        ]);
    }

    public function dashboard(): void
    {
        session_start();
        
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        require_once __DIR__ . '/../views/dashboard.php';
    }

    private function jsonResponse(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
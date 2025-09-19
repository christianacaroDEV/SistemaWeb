<?php

namespace SistemaWeb\Infrastructure\Container;

use SistemaWeb\Application\UseCases\Auth\LoginUseCase;
use SistemaWeb\Application\UseCases\Auth\RegisterUseCase;
use SistemaWeb\Domain\Repositories\UserRepositoryInterface;
use SistemaWeb\Infrastructure\Database\DatabaseConnection;
use SistemaWeb\Infrastructure\Repositories\MySQLUserRepository;
use SistemaWeb\Presentation\Controllers\AuthController;

class DependencyContainer
{
    private array $services = [];
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->registerServices();
    }

    private function registerServices(): void
    {
        // Database
        $this->services[DatabaseConnection::class] = function () {
            return new DatabaseConnection($this->config['database']);
        };

        // Repositories
        $this->services[UserRepositoryInterface::class] = function () {
            return new MySQLUserRepository($this->get(DatabaseConnection::class));
        };

        // Use Cases
        $this->services[LoginUseCase::class] = function () {
            return new LoginUseCase($this->get(UserRepositoryInterface::class));
        };

        $this->services[RegisterUseCase::class] = function () {
            return new RegisterUseCase($this->get(UserRepositoryInterface::class));
        };

        // Controllers
        $this->services[AuthController::class] = function () {
            return new AuthController(
                $this->get(LoginUseCase::class),
                $this->get(RegisterUseCase::class)
            );
        };
    }

    public function get(string $serviceId)
    {
        if (!isset($this->services[$serviceId])) {
            throw new \InvalidArgumentException("Servicio no encontrado: {$serviceId}");
        }

        if (is_callable($this->services[$serviceId])) {
            $this->services[$serviceId] = $this->services[$serviceId]();
        }

        return $this->services[$serviceId];
    }

    public function has(string $serviceId): bool
    {
        return isset($this->services[$serviceId]);
    }
}
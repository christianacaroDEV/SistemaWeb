<?php

namespace SistemaWeb\Application\UseCases\Auth;

use SistemaWeb\Domain\Entities\User;
use SistemaWeb\Domain\Repositories\UserRepositoryInterface;
use SistemaWeb\Domain\Exceptions\UserNotFoundException;
use InvalidArgumentException;

class LoginUseCase
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(LoginRequest $request): LoginResponse
    {
        $this->validateRequest($request);

        $user = $this->userRepository->findByEmail($request->getEmail());

        if (!$user) {
            throw new UserNotFoundException('Credenciales incorrectas');
        }

        if (!$user->verifyPassword($request->getPassword())) {
            throw new InvalidArgumentException('Credenciales incorrectas');
        }

        // Actualizar último login
        $user->updateLastLogin();
        $this->userRepository->save($user);

        return new LoginResponse(
            true,
            'Login exitoso',
            $user->toArray()
        );
    }

    private function validateRequest(LoginRequest $request): void
    {
        if (empty($request->getEmail())) {
            throw new InvalidArgumentException('El email es requerido');
        }

        if (empty($request->getPassword())) {
            throw new InvalidArgumentException('La contraseña es requerida');
        }
    }
}
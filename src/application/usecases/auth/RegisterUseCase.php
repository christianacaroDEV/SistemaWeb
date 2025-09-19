<?php

namespace SistemaWeb\Application\UseCases\Auth;

use SistemaWeb\Domain\Entities\User;
use SistemaWeb\Domain\Repositories\UserRepositoryInterface;
use InvalidArgumentException;

class RegisterUseCase
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(RegisterRequest $request): RegisterResponse
    {
        $this->validateRequest($request);

        if ($this->userRepository->emailExists($request->getEmail())) {
            throw new InvalidArgumentException('El email ya está registrado');
        }

        $user = new User(
            $this->generateUserId(),
            $request->getEmail(),
            password_hash($request->getPassword(), PASSWORD_DEFAULT),
            $request->getName()
        );

        $this->userRepository->save($user);

        return new RegisterResponse(
            true,
            'Usuario registrado exitosamente',
            $user->toArray()
        );
    }

    private function validateRequest(RegisterRequest $request): void
    {
        if (empty($request->getEmail())) {
            throw new InvalidArgumentException('El email es requerido');
        }

        if (empty($request->getPassword())) {
            throw new InvalidArgumentException('La contraseña es requerida');
        }

        if (empty($request->getName())) {
            throw new InvalidArgumentException('El nombre es requerido');
        }

        if (strlen($request->getPassword()) < 8) {
            throw new InvalidArgumentException('La contraseña debe tener al menos 8 caracteres');
        }

        if (!filter_var($request->getEmail(), FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('El formato del email no es válido');
        }
    }

    private function generateUserId(): string
    {
        return uniqid('user_', true);
    }
}
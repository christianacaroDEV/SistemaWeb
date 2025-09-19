<?php

namespace SistemaWeb\Domain\Entities;

use InvalidArgumentException;

class User
{
    private string $id;
    private string $email;
    private string $password;
    private string $name;
    private \DateTime $createdAt;
    private ?\DateTime $lastLogin;

    public function __construct(
        string $id,
        string $email,
        string $password,
        string $name,
        ?\DateTime $createdAt = null,
        ?\DateTime $lastLogin = null
    ) {
        $this->validateEmail($email);
        $this->validatePassword($password);
        $this->validateName($name);

        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
        $this->createdAt = $createdAt ?? new \DateTime();
        $this->lastLogin = $lastLogin;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getLastLogin(): ?\DateTime
    {
        return $this->lastLogin;
    }

    public function updateLastLogin(): void
    {
        $this->lastLogin = new \DateTime();
    }

    public function verifyPassword(string $plainPassword): bool
    {
        return password_verify($plainPassword, $this->password);
    }

    public function changePassword(string $newPassword): void
    {
        $this->validatePassword($newPassword);
        $this->password = password_hash($newPassword, PASSWORD_DEFAULT);
    }

    private function validateEmail(string $email): void
    {
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Email inválido');
        }
    }

    private function validatePassword(string $password): void
    {
        if (empty($password)) {
            throw new InvalidArgumentException('La contraseña no puede estar vacía');
        }
        
        if (strlen($password) < 8) {
            throw new InvalidArgumentException('La contraseña debe tener al menos 8 caracteres');
        }
    }

    private function validateName(string $name): void
    {
        if (empty($name) || strlen($name) < 2) {
            throw new InvalidArgumentException('El nombre debe tener al menos 2 caracteres');
        }
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'created_at' => $this->createdAt->format('Y-m-d H:i:s'),
            'last_login' => $this->lastLogin ? $this->lastLogin->format('Y-m-d H:i:s') : null
        ];
    }
}
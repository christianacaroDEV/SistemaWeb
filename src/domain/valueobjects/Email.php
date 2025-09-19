<?php

namespace SistemaWeb\Domain\ValueObjects;

use InvalidArgumentException;

class Email
{
    private string $value;

    public function __construct(string $email)
    {
        $this->validate($email);
        $this->value = strtolower(trim($email));
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function equals(Email $email): bool
    {
        return $this->value === $email->getValue();
    }

    private function validate(string $email): void
    {
        if (empty($email)) {
            throw new InvalidArgumentException('El email no puede estar vacío');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('El formato del email no es válido');
        }

        if (strlen($email) > 255) {
            throw new InvalidArgumentException('El email no puede tener más de 255 caracteres');
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
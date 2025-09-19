<?php

namespace SistemaWeb\Domain\Exceptions;

class UserNotFoundException extends DomainException
{
    public function __construct(string $message = 'Usuario no encontrado')
    {
        parent::__construct($message, 404);
    }
}
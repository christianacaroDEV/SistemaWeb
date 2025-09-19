<?php

namespace SistemaWeb\Application\UseCases\Auth;

class RegisterResponse
{
    private bool $success;
    private string $message;
    private ?array $userData;

    public function __construct(bool $success, string $message, ?array $userData = null)
    {
        $this->success = $success;
        $this->message = $message;
        $this->userData = $userData;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getUserData(): ?array
    {
        return $this->userData;
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'data' => $this->userData
        ];
    }
}
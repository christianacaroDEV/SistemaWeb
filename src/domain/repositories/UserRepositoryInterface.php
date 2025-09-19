<?php

namespace SistemaWeb\Domain\Repositories;

use SistemaWeb\Domain\Entities\User;

interface UserRepositoryInterface
{
    public function findByEmail(string $email): ?User;
    
    public function findById(string $id): ?User;
    
    public function save(User $user): void;
    
    public function delete(string $id): void;
    
    public function emailExists(string $email): bool;
}
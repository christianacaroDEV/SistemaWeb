<?php

namespace SistemaWeb\Infrastructure\Repositories;

use PDO;
use SistemaWeb\Domain\Entities\User;
use SistemaWeb\Domain\Repositories\UserRepositoryInterface;
use SistemaWeb\Infrastructure\Database\DatabaseConnection;

class MySQLUserRepository implements UserRepositoryInterface
{
    private PDO $connection;

    public function __construct(DatabaseConnection $database)
    {
        $this->connection = $database->getConnection();
    }

    public function findByEmail(string $email): ?User
    {
        $stmt = $this->connection->prepare(
            'SELECT * FROM users WHERE email = :email LIMIT 1'
        );
        
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$userData) {
            return null;
        }
        
        return $this->mapToUser($userData);
    }

    public function findById(string $id): ?User
    {
        $stmt = $this->connection->prepare(
            'SELECT * FROM users WHERE id = :id LIMIT 1'
        );
        
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$userData) {
            return null;
        }
        
        return $this->mapToUser($userData);
    }

    public function save(User $user): void
    {
        $existingUser = $this->findById($user->getId());
        
        if ($existingUser) {
            $this->update($user);
        } else {
            $this->insert($user);
        }
    }

    public function delete(string $id): void
    {
        $stmt = $this->connection->prepare('DELETE FROM users WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function emailExists(string $email): bool
    {
        $stmt = $this->connection->prepare(
            'SELECT COUNT(*) FROM users WHERE email = :email'
        );
        
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        return $stmt->fetchColumn() > 0;
    }

    private function insert(User $user): void
    {
        $stmt = $this->connection->prepare(
            'INSERT INTO users (id, email, password, name, created_at, last_login) 
             VALUES (:id, :email, :password, :name, :created_at, :last_login)'
        );

        $id = $user->getId();
        $email = $user->getEmail();
        $password = $user->getPassword();
        $name = $user->getName();
        $createdAt = $user->getCreatedAt()->format('Y-m-d H:i:s');
        $lastLogin = $user->getLastLogin() ? $user->getLastLogin()->format('Y-m-d H:i:s') : null;

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':created_at', $createdAt);
        $stmt->bindParam(':last_login', $lastLogin);
        
        $stmt->execute();
    }

    private function update(User $user): void
    {
        $stmt = $this->connection->prepare(
            'UPDATE users SET 
                email = :email, 
                password = :password, 
                name = :name, 
                last_login = :last_login 
             WHERE id = :id'
        );

        $id = $user->getId();
        $email = $user->getEmail();
        $password = $user->getPassword();
        $name = $user->getName();
        $lastLogin = $user->getLastLogin() ? $user->getLastLogin()->format('Y-m-d H:i:s') : null;

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':last_login', $lastLogin);
        
        $stmt->execute();
    }

    private function mapToUser(array $userData): User
    {
        return new User(
            $userData['id'],
            $userData['email'],
            $userData['password'],
            $userData['name'],
            new \DateTime($userData['created_at']),
            $userData['last_login'] ? new \DateTime($userData['last_login']) : null
        );
    }
}
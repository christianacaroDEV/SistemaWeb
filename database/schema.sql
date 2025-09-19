-- Script SQL para crear la base de datos y tabla de usuarios
-- Sistema Web con Arquitectura Hexagonal

-- Crear base de datos
CREATE DATABASE IF NOT EXISTS sistema_web 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE sistema_web;

-- Crear tabla de usuarios
CREATE TABLE IF NOT EXISTS users (
    id VARCHAR(50) PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar usuario de prueba (contraseña: password123)
INSERT INTO users (id, email, password, name) VALUES 
('user_test_001', 
 'admin@sistemaWeb.com', 
 '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
 'Administrador del Sistema');

-- Verificar la creación
SELECT * FROM users;
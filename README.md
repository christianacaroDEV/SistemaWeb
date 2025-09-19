# SistemaWeb - Login con Arquitectura Hexagonal

Sistema Web multiempresa implementado con arquitectura hexagonal en PHP.

## 🏗️ Arquitectura

Este proyecto implementa **Arquitectura Hexagonal** (también conocida como Ports and Adapters) que separa la lógica de negocio de los detalles de implementación:

### Estructura de Capas

```
src/
├── domain/              # Capa de Dominio (Entidades, Value Objects, Interfaces)
│   ├── entities/        # Entidades del negocio
│   ├── repositories/    # Interfaces de repositorios
│   ├── valueobjects/    # Objetos de valor
│   └── exceptions/      # Excepciones del dominio
├── application/         # Capa de Aplicación (Casos de Uso)
│   └── usecases/        # Casos de uso del sistema
├── infrastructure/     # Capa de Infraestructura (Implementaciones)
│   ├── database/       # Conexión a base de datos
│   ├── repositories/   # Implementación de repositorios
│   └── container/      # Inyección de dependencias
└── presentation/       # Capa de Presentación (Controladores, Vistas)
    ├── controllers/    # Controladores web
    └── views/          # Plantillas HTML
```

## 🚀 Características

- ✅ **Login de usuarios** con validación
- ✅ **Registro de usuarios** con validación
- ✅ **Dashboard** protegido con sesiones
- ✅ **Validación en tiempo real** (JavaScript)
- ✅ **Arquitectura hexagonal** bien estructurada
- ✅ **Inyección de dependencias** personalizada
- ✅ **Interfaz responsive** moderna
- ✅ **Manejo de errores** robusto

## 📋 Requisitos

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Apache con mod_rewrite habilitado
- WAMP/XAMPP (recomendado para desarrollo)

## 🛠️ Instalación

### 1. Clonar el proyecto
```bash
git clone <url-del-repositorio>
cd SistemaWeb
```

### 2. Configurar la base de datos
- Ejecutar el script SQL en `database/schema.sql` en tu servidor MySQL
- Esto creará la base de datos `sistema_web` y la tabla `users`

### 3. Configurar variables de entorno
```bash
cp .env.example .env
```

Editar el archivo `.env` con tus datos de conexión:
```env
DB_HOST=localhost
DB_PORT=3306
DB_NAME=sistema_web
DB_USER=root
DB_PASS=tu_password

APP_ENV=development
APP_DEBUG=true
```

### 4. Configurar Apache
Asegúrate de que tu servidor web apunte al directorio raíz del proyecto y que mod_rewrite esté habilitado.

## 🚀 Uso

### Acceder al sistema
1. Visita `http://localhost/SistemaWeb` en tu navegador
2. Serás redirigido automáticamente a la página de login

### Credenciales de prueba
- **Email:** admin@sistemaWeb.com
- **Contraseña:** password123

### Crear nueva cuenta
1. Haz clic en "Registrarse" en la página de login
2. Completa el formulario de registro
3. Serás automáticamente logueado y redirigido al dashboard

## 🏛️ Principios de Arquitectura Hexagonal

### 1. Dominio (Centro)
- **Entidades:** `User` - Contiene la lógica de negocio pura
- **Value Objects:** `Email` - Objetos inmutables con validación
- **Interfaces:** `UserRepositoryInterface` - Contratos para la persistencia

### 2. Aplicación (Casos de Uso)
- **LoginUseCase:** Maneja la lógica de autenticación
- **RegisterUseCase:** Maneja la lógica de registro
- **Request/Response Objects:** DTOs para comunicación

### 3. Infraestructura (Adaptadores)
- **MySQLUserRepository:** Implementación concreta para MySQL
- **DatabaseConnection:** Manejo de conexiones a BD
- **DependencyContainer:** Inyección de dependencias

### 4. Presentación (Interfaz)
- **AuthController:** Maneja requests HTTP
- **Views:** Plantillas HTML para el frontend

## 🔧 Estructura de Archivos

```
SistemaWeb/
├── src/
│   ├── domain/
│   │   ├── entities/User.php
│   │   ├── valueobjects/Email.php
│   │   ├── repositories/UserRepositoryInterface.php
│   │   └── exceptions/
│   ├── application/
│   │   └── usecases/auth/
│   ├── infrastructure/
│   │   ├── database/DatabaseConnection.php
│   │   ├── repositories/MySQLUserRepository.php
│   │   └── container/DependencyContainer.php
│   └── presentation/
│       ├── controllers/AuthController.php
│       └── views/
├── public/
│   ├── css/
│   └── js/
├── config/
├── database/
├── index.php
├── bootstrap.php
├── autoload.php
└── .htaccess
```

## 🎯 Ventajas de esta Arquitectura

1. **Separación de responsabilidades** clara
2. **Fácil testing** - cada capa se puede testear independientemente
3. **Flexibilidad** - se puede cambiar la BD sin afectar la lógica de negocio
4. **Mantenibilidad** - código organizado y fácil de entender
5. **Escalabilidad** - fácil agregar nuevas funcionalidades

## 🧪 Testing

La arquitectura permite testing fácil:
- **Unidades:** Testear entidades y casos de uso
- **Integración:** Testear repositorios con BD real
- **Funcional:** Testear controladores con requests HTTP

## 📝 Próximas Mejoras

- [ ] Tests automatizados (PHPUnit)
- [ ] Validación con JWT tokens
- [ ] API REST endpoints
- [ ] Cache con Redis
- [ ] Logs estructurados
- [ ] Docker containerización

## 🤝 Contribución

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## 📄 Licencia

Este proyecto está bajo la Licencia MIT - ver el archivo [LICENSE](LICENSE) para detalles.
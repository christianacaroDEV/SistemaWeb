<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Sistema Web</title>
    <link rel="stylesheet" href="/public/css/auth.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1>Iniciar Sesión</h1>
                <p>Ingresa tus credenciales para acceder al sistema</p>
            </div>
            
            <form id="loginForm" class="auth-form">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                    <span class="error-message" id="email-error"></span>
                </div>
                
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required>
                    <span class="error-message" id="password-error"></span>
                </div>
                
                <button type="submit" class="btn-primary" id="submitBtn">
                    <span class="btn-text">Iniciar Sesión</span>
                    <span class="btn-loading" style="display: none;">Iniciando...</span>
                </button>
            </form>
            
            <div class="auth-footer">
                <p>¿No tienes cuenta? <a href="/register">Registrarse</a></p>
            </div>
            
            <div id="message" class="message" style="display: none;"></div>
        </div>
    </div>
    
    <script src="/public/js/auth.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initializeLoginForm();
        });
    </script>
</body>
</html>
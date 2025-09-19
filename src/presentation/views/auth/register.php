<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse - Sistema Web</title>
    <link rel="stylesheet" href="/public/css/auth.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1>Crear Cuenta</h1>
                <p>Completa los datos para registrarte en el sistema</p>
            </div>
            
            <form id="registerForm" class="auth-form">
                <div class="form-group">
                    <label for="name">Nombre Completo</label>
                    <input type="text" id="name" name="name" required>
                    <span class="error-message" id="name-error"></span>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                    <span class="error-message" id="email-error"></span>
                </div>
                
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required>
                    <small class="help-text">Mínimo 8 caracteres</small>
                    <span class="error-message" id="password-error"></span>
                </div>
                
                <div class="form-group">
                    <label for="password_confirm">Confirmar Contraseña</label>
                    <input type="password" id="password_confirm" name="password_confirm" required>
                    <span class="error-message" id="password_confirm-error"></span>
                </div>
                
                <button type="submit" class="btn-primary" id="submitBtn">
                    <span class="btn-text">Crear Cuenta</span>
                    <span class="btn-loading" style="display: none;">Registrando...</span>
                </button>
            </form>
            
            <div class="auth-footer">
                <p>¿Ya tienes cuenta? <a href="/login">Iniciar Sesión</a></p>
            </div>
            
            <div id="message" class="message" style="display: none;"></div>
        </div>
    </div>
    
    <script src="/public/js/auth.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initializeRegisterForm();
        });
    </script>
</body>
</html>
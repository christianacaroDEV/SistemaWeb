<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistema Web</title>
    <link rel="stylesheet" href="/public/css/dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <header class="dashboard-header">
            <div class="header-content">
                <h1>Dashboard</h1>
                <div class="user-info">
                    <span>Bienvenido, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                    <button id="logoutBtn" class="btn-secondary">Cerrar Sesión</button>
                </div>
            </div>
        </header>
        
        <main class="dashboard-main">
            <div class="dashboard-grid">
                <div class="card">
                    <h3>Información del Usuario</h3>
                    <p><strong>ID:</strong> <?php echo htmlspecialchars($_SESSION['user_id']); ?></p>
                    <p><strong>Nombre:</strong> <?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['user_email']); ?></p>
                </div>
                
                <div class="card">
                    <h3>Sistema Web</h3>
                    <p>Bienvenido al sistema web con arquitectura hexagonal.</p>
                    <p>Este dashboard demuestra la implementación exitosa del sistema de autenticación.</p>
                </div>
                
                <div class="card">
                    <h3>Acciones Rápidas</h3>
                    <ul>
                        <li><a href="#" class="dashboard-link">Ver Perfil</a></li>
                        <li><a href="#" class="dashboard-link">Configuración</a></li>
                        <li><a href="#" class="dashboard-link">Ayuda</a></li>
                    </ul>
                </div>
            </div>
        </main>
    </div>
    
    <script>
        document.getElementById('logoutBtn').addEventListener('click', function() {
            if (confirm('¿Estás seguro de que quieres cerrar sesión?')) {
                fetch('/logout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = '/login';
                    }
                });
            }
        });
    </script>
</body>
</html>
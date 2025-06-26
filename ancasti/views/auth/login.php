<?php 

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

require_once 'views/layout/header.php'; 
?>

<div class="login-page-container">
    <div class="login-content">

        <div class="login-logo">
            <img src="assets/imagenes/Imagen de WhatsApp 2025-06-20 a las 23.47.39_e7804b75.jpg" 
                 alt="Logo del Sistema" 
                 class="logo-image">
            <div class="logo-text">
                <h1>Sistema de Control</h1>
                <h2>de Ventas</h2>
                <p>Gestiona tu negocio de manera eficiente</p>
            </div>
        </div>

        <div class="login-form-container">
            <div class="login-form-header">
                <h2>🔐 Iniciar Sesión</h2>
                <p>Accede a tu cuenta para continuar</p>
            </div>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    ⚠️ <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <form action="index.php?action=login" method="post" class="login-form">
                <div class="form-group">
                    <label for="id_usuario">👤 Usuario:</label>
                    <input type="text" id="id_usuario" name="id_usuario" required 
                           placeholder="Ingrese su usuario" autocomplete="username">
                </div>
                
                <div class="form-group">
                    <label for="contraseña">🔑 Contraseña:</label>
                    <input type="password" id="contraseña" name="contraseña" required 
                           placeholder="Ingrese su contraseña" autocomplete="current-password">
                </div>
                
                <button type="submit" class="login-button">
                    🚀 Ingresar al Sistema
                </button>
            </form>
            
            <div class="login-footer">
                <p>Sistema de Control de Ventas v2.0</p>
                <p>Desarrollado con ❤️ para tu negocio</p>
            </div>
        </div>
    </div>
</div>

<script>

if (window.history && window.history.pushState) {
    window.history.pushState(null, null, window.location.href);
    window.addEventListener('popstate', function() {
        window.history.pushState(null, null, window.location.href);
    });
}

window.addEventListener('beforeunload', function() {
    // Forzar recarga desde el servidor
    if (window.performance && window.performance.navigation.type === 2) {
        window.location.reload();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('id_usuario').focus();
});
</script>

<?php require_once 'views/layout/footer.php'; ?>
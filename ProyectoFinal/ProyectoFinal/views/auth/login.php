<?php require_once 'views/layout/header.php'; ?>

<h2>Iniciar Sesión</h2>
<?php if (isset($error)): ?>
    <div class="error"><?php echo $error; ?></div>
<?php endif; ?>

<div style="margin: auto ;">
    <form action="index.php?action=login" method="post">
    <div>
        <label for="id_usuario">Usuario:</label>
        <input type="text" id="id_usuario" name="id_usuario" required>
    </div>
    <div>
        <label for="contraseña">Contraseña:</label>
        <input type="password" id="contraseña" name="contraseña" required>
    </div>
    <button type="submit">Ingresar</button>
</form>
</div>

<?php require_once 'views/layout/footer.php'; ?>
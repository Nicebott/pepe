<?php require_once 'views/layout/header.php'; ?>

<h2>Agregar Cliente</h2>

<?php if (isset($error)): ?>
    <div class="error"><?php echo $error; ?></div>
<?php endif; ?>

<form action="index.php?action=clientes&method=add" method="post">
    <div>
        <label for="cedula_rif">Cédula/RIF:</label>
        <input type="text" id="cedula_rif" name="cedula_rif" required>
    </div>
    <div>
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
    </div>
    <div>
        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido">
    </div>
    <div>
        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono">
    </div>
    <div>
        <label for="direccion">Dirección:</label>
        <textarea id="direccion" name="direccion"></textarea>
    </div>
    <div>
        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo">
    </div>
    <button type="submit">Guardar</button>
    <a href="index.php?action=clientes&method=list" class="btn">Cancelar</a>
</form>

<?php require_once 'views/layout/footer.php'; ?>
<?php require_once 'views/layout/header.php'; ?>

<h2>Editar Cliente</h2>

<?php if (isset($error)): ?>
    <div class="error"><?php echo $error; ?></div>
<?php endif; ?>

<form action="index.php?action=clientes&method=edit&id=<?php echo $client['Cedula_Rif']; ?>" method="post">
    <div>
        <label for="cedula_rif">Cédula/RIF:</label>
        <input type="text" id="cedula_rif" name="cedula_rif" value="<?php echo $client['Cedula_Rif']; ?>" readonly>
    </div>
    <div>
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $client['Nombre']; ?>" required>
    </div>
    <div>
        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" value="<?php echo $client['Apellido']; ?>">
    </div>
    <div>
        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" value="<?php echo $client['Telefono']; ?>">
    </div>
    <div>
        <label for="direccion">Dirección:</label>
        <textarea id="direccion" name="direccion"><?php echo $client['Direccion']; ?></textarea>
    </div>
    <div>
        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" value="<?php echo $client['Correo']; ?>">
    </div>
    <button type="submit">Actualizar</button>
    <a href="index.php?action=clientes&method=list" class="btn">Cancelar</a>
</form>

<?php require_once 'views/layout/footer.php'; ?>
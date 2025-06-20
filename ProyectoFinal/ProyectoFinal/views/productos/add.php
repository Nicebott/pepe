<?php require_once 'views/layout/header.php'; ?>

<h2>Agregar Producto</h2>

<?php if (isset($error)): ?>
    <div class="error"><?php echo $error; ?></div>
<?php endif; ?>

<form action="index.php?action=productos&method=add" method="post">
    <div>
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
    </div>
    <div>
        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" step="0.01" min="0" required>
    </div>
    <div>
        <label for="unidad">Unidad:</label>
        <input type="text" id="unidad" name="unidad" required>
    </div>
    <div>
        <label for="cantidad">Cantidad Inicial:</label>
        <input type="number" id="cantidad" name="cantidad" min="0" required>
    </div>
    <button type="submit">Guardar</button>
    <a href="index.php?action=productos&method=list" class="btn">Cancelar</a>
</form>

<?php require_once 'views/layout/footer.php'; ?>
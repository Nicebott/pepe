<?php require_once 'views/layout/header.php'; ?>

<h2>Editar Producto</h2>

<?php if (isset($error)): ?>
    <div class="error"><?php echo $error; ?></div>
<?php endif; ?>

<form action="index.php?action=productos&method=edit&id=<?php echo $product['id_producto']; ?>" method="post">
    <div>
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $product['Nombre']; ?>" required>
    </div>
    <div>
        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" step="0.01" min="0" 
               value="<?php echo $product['Precio']; ?>" required>
    </div>
    <div>
        <label for="unidad">Unidad:</label>
        <input type="text" id="unidad" name="unidad" value="<?php echo $product['Unidad']; ?>" required>
    </div>
    <div>
        <label for="cantidad">Cantidad:</label>
        <input type="number" id="cantidad" name="cantidad" min="0" 
               value="<?php echo $product['Cantidad']; ?>" required>
    </div>
    <button type="submit">Actualizar</button>
    <a href="index.php?action=productos&method=list" class="btn">Cancelar</a>
</form>

<?php require_once 'views/layout/footer.php'; ?>
<?php require_once 'views/layout/header.php'; ?>

<h2>Lista de Productos</h2>
<a href="index.php?action=productos&method=add" class="btn">Agregar Producto</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Unidad</th>
            <th>Stock</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product): ?>
        <tr>
            <td><?php echo $product['id_producto']; ?></td>
            <td><?php echo $product['Nombre']; ?></td>
            <td><?php echo number_format($product['Precio'], 2); ?></td>
            <td><?php echo $product['Unidad']; ?></td>
            <td><?php echo $product['Cantidad']; ?></td>
            <td>
                <a href="index.php?action=productos&method=edit&id=<?php echo $product['id_producto']; ?>">Editar</a>
                <a href="index.php?action=productos&method=delete&id=<?php echo $product['id_producto']; ?>" 
                   onclick="return confirm('¿Estás seguro de eliminar este producto?')">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once 'views/layout/footer.php'; ?>
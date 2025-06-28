<?php require_once 'views/layout/header.php'; ?>

<h2>Productos Más Vendidos</h2>

<table>
    <thead>
        <tr>
            <th>Producto</th>
            <th>Cantidad Vendida</th>
            <th>Total Vendido</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product): ?>
        <tr>
            <td><?php echo $product['producto_nombre']; ?></td>
            <td><?php echo $product['total_cantidad']; ?></td>
            <td>Bs <?php echo number_format($product['total_venta'], 2); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once 'views/layout/footer.php'; ?>
<?php require_once 'views/layout/header.php'; ?>

<h2>Productos con Stock Bajo</h2>

<form action="index.php?action=reportes&method=lowStock" method="get">
    <div class="form-group">
        <label for="threshold">Umbral de Stock:</label>
        <input type="number" id="threshold" name="threshold" min="1" value="<?php echo isset($threshold) ? $threshold : 10; ?>">
        <button type="submit">Filtrar</button>
    </div>
</form>

<table>
    <thead>
        <tr>
            <th>Producto</th>
            <th>Precio</th>
            <th>Unidad</th>
            <th>Stock Actual</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product): ?>
        <tr>
            <td><?php echo $product['Nombre']; ?></td>
            <td>$<?php echo number_format($product['Precio'], 2); ?></td>
            <td><?php echo $product['Unidad']; ?></td>
            <td class="<?php echo $product['Cantidad'] < 5 ? 'danger' : 'warning'; ?>">
                <?php echo $product['Cantidad']; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once 'views/layout/footer.php'; ?>
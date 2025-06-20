<?php require_once 'views/layout/header.php'; ?>

<h2>Lista de Ventas</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>Total</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($sales as $sale): ?>
        <tr>
            <td><?php echo $sale['id_venta']; ?></td>
            <td><?php echo $sale['Fecha_Emision']; ?></td>
            <td><?php echo $sale['Nombre'] . ' ' . $sale['Apellido']; ?></td>
            <td>$<?php echo number_format($sale['Total'], 2); ?></td>
            <td>
                <a href="index.php?action=ventas&method=details&id=<?php echo $sale['id_venta']; ?>">Detalles</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once 'views/layout/footer.php'; ?>
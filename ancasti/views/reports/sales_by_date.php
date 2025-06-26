<?php require_once 'views/layout/header.php'; ?>

<h2>Reporte de Ventas por Fecha</h2>

<form action="index.php?action=reportes&method=salesByDate" method="post">
    <div class="form-group">
        <label for="start_date">Fecha Inicio:</label>
        <input type="date" id="start_date" name="start_date" required>
    </div>
    <div class="form-group">
        <label for="end_date">Fecha Fin:</label>
        <input type="date" id="end_date" name="end_date" required>
    </div>
    <button type="submit">Generar Reporte</button>
</form>

<?php if (isset($sales)): ?>
    <h3>Resultados del <?php echo $startDate; ?> al <?php echo $endDate; ?></h3>
    
    <table>
        <thead>
            <tr>
                <th>ID Venta</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sales as $sale): ?>
            <tr>
                <td><?php echo $sale['id_venta']; ?></td>
                <td><?php echo $sale['Fecha_Emision']; ?></td>
                <td><?php echo $sale['Nombre'] . ' ' . $sale['Apellido']; ?></td>
                <td>$<?php echo number_format($sale['Total'], 2); ?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3"><strong>Total General</strong></td>
                <td><strong>$<?php echo number_format($total, 2); ?></strong></td>
            </tr>
        </tbody>
    </table>
<?php endif; ?>

<?php require_once 'views/layout/footer.php'; ?>
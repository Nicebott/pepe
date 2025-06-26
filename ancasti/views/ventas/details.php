<?php require_once 'views/layout/header.php'; ?>

<h2>Detalles de Venta #<?php echo $sale['id_venta']; ?></h2>

<div class="sale-info">
    <p><strong>Fecha:</strong> <?php echo $sale['Fecha_Emision']; ?></p>
    <p><strong>Cliente:</strong> <?php echo $sale['Nombre'] . ' ' . $sale['Apellido']; ?></p>
    <p><strong>Cédula/RIF:</strong> <?php echo $sale['Cedula_Rif']; ?></p>
    <p><strong>Total:</strong> Bs <?php echo number_format($sale['Total'], 2); ?></p>
</div>

<h3>Productos Vendidos</h3>
<table>
    <thead>
        <tr>
            <th>Producto</th>
            <th>Precio Unitario</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($saleDetails as $detail): ?>
        <tr>
            <td><?php echo $detail['producto_nombre']; ?></td>
            <td>Bs <?php echo number_format($detail['Precio_Unitario'], 2); ?></td>
            <td><?php echo $detail['Cantidad']; ?></td>
            <td>Bs <?php echo number_format($detail['Precio_Unitario'] * $detail['Cantidad'], 2); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h3>Pagos</h3>
<?php foreach ($payments as $payment): ?>
    <div class="payment">
        <p><strong>Pago #<?php echo $payment['id_pago_venta']; ?></strong></p>
        <p><strong>Fecha:</strong> <?php echo $payment['Fecha']; ?></p>
        <p><strong>Monto:</strong> Bs <?php echo number_format($payment['Monto'], 2); ?></p>
        
        <h4>Detalles del Pago</h4>
        <table>
            <thead>
                <tr>
                    <th>Método</th>
                    <th>Monto</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($paymentDetails[$payment['id_pago_venta']] as $detail): ?>
                <tr>
                    <td><?php echo $detail['Metodo_Pago']; ?></td>
                    <td>Bs <?php echo number_format($detail['Monto'], 2); ?></td>
                    <td><?php echo $detail['Fecha']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endforeach; ?>

<a href="index.php?action=ventas&method=list" class="btn">Volver a la lista</a>

<?php require_once 'views/layout/footer.php'; ?>
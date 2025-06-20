<?php require_once 'views/layout/header.php'; ?>

<h2>Nueva Venta</h2>

<?php if (isset($error)): ?>
    <div class="error"><?php echo $error; ?></div>
<?php endif; ?>

<form action="index.php?action=ventas&method=new" method="post">
    <div class="form-group">
        <label for="client_search">Buscar Cliente:</label>
        <input type="text" id="client_search" placeholder="Cédula/RIF o Nombre">
        <select id="cedula_rif" name="cedula_rif" required>
            <option value="">Seleccione un cliente</option>
            <?php foreach ($clients as $client): ?>
                <option value="<?php echo $client['Cedula_Rif']; ?>">
                    <?php echo $client['Cedula_Rif'] . ' - ' . $client['Nombre'] . ' ' . $client['Apellido']; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="product_search">Buscar Producto:</label>
        <input type="text" id="product_search" placeholder="Nombre del producto">
        <select id="product_id" name="product_id">
            <option value="">Seleccione un producto</option>
            <?php foreach ($products as $product): ?>
                <?php if ($product['Cantidad'] > 0): ?>
                    <option value="<?php echo $product['id_producto']; ?>" 
                            data-price="<?php echo $product['Precio']; ?>"
                            data-stock="<?php echo $product['Cantidad']; ?>">
                        <?php echo $product['Nombre'] . ' - $' . $product['Precio'] . ' - Stock: ' . $product['Cantidad']; ?>
                    </option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
        <input type="number" id="quantity" name="quantity" min="1" value="1">
        <button type="submit" name="add_to_cart">Agregar</button>
    </div>
</form>

<h3>Carrito de Compra</h3>
<?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Precio Unitario</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_SESSION['cart'] as $index => $item): ?>
                <tr>
                    <td><?php echo $item['nombre']; ?></td>
                    <td>$<?php echo number_format($item['precio'], 2); ?></td>
                    <td><?php echo $item['cantidad']; ?></td>
                    <td>$<?php echo number_format($item['subtotal'], 2); ?></td>
                    <td>
                        <form action="index.php?action=ventas&method=new" method="post">
                            <input type="hidden" name="item_index" value="<?php echo $index; ?>">
                            <button type="submit" name="remove_item">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3"><strong>Total</strong></td>
                <td><strong>$<?php echo number_format(array_sum(array_column($_SESSION['cart'], 'subtotal')), 2); ?></strong></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <form action="index.php?action=ventas&method=new" method="post">
        <input type="hidden" name="cedula_rif" value="<?php echo isset($_POST['cedula_rif']) ? $_POST['cedula_rif'] : ''; ?>">
        
        <div class="form-group">
            <label for="payment_method">Método de Pago:</label>
            <select id="payment_method" name="payment_method" required>
                <option value="Efectivo">Efectivo</option>
                <option value="Transferencia">Transferencia</option>
                <option value="Tarjeta">Tarjeta</option>
                <option value="Divisas">Divisas</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="amount_paid">Monto Pagado:</label>
            <input type="number" id="amount_paid" name="amount_paid" step="0.01" min="0" 
                   value="<?php echo array_sum(array_column($_SESSION['cart'], 'subtotal')); ?>" required>
        </div>
        
        <div id="exchange_rate_fields" style="display: none;">
            <div class="form-group">
                <label for="exchange_rate">Tasa de Cambio:</label>
                <input type="number" id="exchange_rate" name="exchange_rate" step="0.01" min="0">
            </div>
            <div class="form-group">
                <label for="exchange_time">Hora:</label>
                <input type="time" id="exchange_time" name="exchange_time">
            </div>
        </div>
        
        <button type="submit" name="finalize_sale">Finalizar Venta</button>
    </form>
<?php else: ?>
    <p>No hay productos en el carrito</p>
<?php endif; ?>

<script>
document.getElementById('payment_method').addEventListener('change', function() {
    const exchangeFields = document.getElementById('exchange_rate_fields');
    if (this.value === 'Divisas') {
        exchangeFields.style.display = 'block';
    } else {
        exchangeFields.style.display = 'none';
    }
});

// Búsqueda simple de clientes
document.getElementById('client_search').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const options = document.getElementById('cedula_rif').options;
    
    for (let i = 0; i < options.length; i++) {
        const text = options[i].text.toLowerCase();
        if (text.includes(searchTerm)) {
            options[i].style.display = '';
        } else {
            options[i].style.display = 'none';
        }
    }
});

// Búsqueda simple de productos
document.getElementById('product_search').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const options = document.getElementById('product_id').options;
    
    for (let i = 0; i < options.length; i++) {
        const text = options[i].text.toLowerCase();
        if (text.includes(searchTerm)) {
            options[i].style.display = '';
        } else {
            options[i].style.display = 'none';
        }
    }
});
</script>

<?php require_once 'views/layout/footer.php'; ?>
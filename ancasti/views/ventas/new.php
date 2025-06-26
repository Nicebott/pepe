<?php require_once 'views/layout/header.php'; ?>

<h2>🛒 Nueva Venta</h2>

<?php if (isset($error)): ?>
    <div class="alert alert-danger">⚠️ <?php echo $error; ?></div>
<?php endif; ?>

<!-- Selección de Cliente -->
<div class="card">
    <h3>👤 Seleccionar Cliente</h3>
    <form action="index.php?action=ventas&method=new" method="post">
        <div class="form-row">
            <div class="form-group">
                <label for="client_search">🔍 Buscar Cliente:</label>
                <input type="text" id="client_search" placeholder="Buscar por cédula, RIF o nombre...">
            </div>
            <div class="form-group">
                <label for="cedula_rif">Cliente:</label>
                <select id="cedula_rif" name="cedula_rif" required>
                    <option value="">Seleccione un cliente</option>
                    <?php foreach ($clients as $client): ?>
                        <option value="<?php echo $client['Cedula_Rif']; ?>" 
                                <?php echo (isset($_POST['cedula_rif']) && $_POST['cedula_rif'] == $client['Cedula_Rif']) ? 'selected' : ''; ?>>
                            <?php echo $client['Cedula_Rif'] . ' - ' . $client['Nombre'] . ' ' . $client['Apellido']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div style="text-align: right;">
            <a href="index.php?action=clientes&method=add" class="btn btn-secondary">➕ Agregar Nuevo Cliente</a>
        </div>
    </form>
</div>

<!-- Agregar Productos -->
<div class="card">
    <h3>📦 Agregar Productos</h3>
    <form action="index.php?action=ventas&method=new" method="post">
        <input type="hidden" name="cedula_rif" value="<?php echo isset($_POST['cedula_rif']) ? $_POST['cedula_rif'] : ''; ?>">
        
        <div class="form-row">
            <div class="form-group">
                <label for="product_search">🔍 Buscar Producto:</label>
                <input type="text" id="product_search" placeholder="Buscar por nombre...">
            </div>
            <div class="form-group">
                <label for="product_id">Producto:</label>
                <select id="product_id" name="product_id" required>
                    <option value="">Seleccione un producto</option>
                    <?php foreach ($products as $product): ?>
                        <?php if ($product['Cantidad'] > 0): ?>
                            <option value="<?php echo $product['id_producto']; ?>" 
                                    data-price="<?php echo $product['Precio']; ?>"
                                    data-stock="<?php echo $product['Cantidad']; ?>">
                                <?php echo $product['Nombre'] . ' - $' . number_format($product['Precio'], 2) . ' - Stock: ' . $product['Cantidad']; ?>
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="quantity">Cantidad:</label>
                <input type="number" id="quantity" name="quantity" min="1" value="1" required>
            </div>
            <div class="form-group" style="display: flex; align-items: end;">
                <button type="submit" name="add_to_cart" class="btn btn-success">➕ Agregar al Carrito</button>
            </div>
        </div>
        
        <div id="product-info" style="display: none; margin-top: 1rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
            <p><strong>Precio:</strong> $<span id="product-price">0.00</span></p>
            <p><strong>Stock disponible:</strong> <span id="product-stock">0</span> unidades</p>
            <p><strong>Subtotal:</strong> $<span id="subtotal">0.00</span></p>
        </div>
    </form>
</div>

<!-- Carrito de Compra -->
<div class="cart-container">
    <h3>🛒 Carrito de Compra</h3>
    
    <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio Unit.</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total = 0;
                    foreach ($_SESSION['cart'] as $index => $item): 
                        $total += $item['subtotal'];
                    ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($item['nombre']); ?></strong></td>
                            <td>$<?php echo number_format($item['precio'], 2); ?></td>
                            <td><?php echo $item['cantidad']; ?></td>
                            <td><strong>$<?php echo number_format($item['subtotal'], 2); ?></strong></td>
                            <td>
                                <form action="index.php?action=ventas&method=new" method="post" style="display: inline;">
                                    <input type="hidden" name="item_index" value="<?php echo $index; ?>">
                                    <input type="hidden" name="cedula_rif" value="<?php echo isset($_POST['cedula_rif']) ? $_POST['cedula_rif'] : ''; ?>">
                                    <button type="submit" name="remove_item" class="btn btn-danger" style="padding: 0.3rem 0.6rem; font-size: 0.8rem;"
                                            onclick="return confirm('¿Eliminar este producto del carrito?')">🗑️ Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="cart-total">
            💰 Total de la Venta: $<?php echo number_format($total, 2); ?>
        </div>

        <!-- Finalizar Venta -->
        <div class="card" style="margin-top: 1.5rem;">
            <h3>💳 Finalizar Venta</h3>
            <form action="index.php?action=ventas&method=new" method="post">
                <input type="hidden" name="cedula_rif" value="<?php echo isset($_POST['cedula_rif']) ? $_POST['cedula_rif'] : ''; ?>">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="payment_method">Método de Pago:</label>
                        <select id="payment_method" name="payment_method" required>
                            <option value="">Seleccione método</option>
                            <option value="Efectivo">💵 Efectivo</option>
                            <option value="Transferencia">🏦 Transferencia</option>
                            <option value="Tarjeta">💳 Tarjeta</option>
                            <option value="Divisas">💱 Divisas</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="amount_paid">Monto Pagado:</label>
                        <input type="number" id="amount_paid" name="amount_paid" step="0.01" min="0" 
                               value="<?php echo $total; ?>" required>
                    </div>
                </div>
                
                <div id="exchange_rate_fields" style="display: none;">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="exchange_rate">💱 Tasa de Cambio:</label>
                            <input type="number" id="exchange_rate" name="exchange_rate" step="0.01" min="0" 
                                   placeholder="Ej: 36.50">
                        </div>
                        <div class="form-group">
                            <label for="exchange_time">🕐 Hora:</label>
                            <input type="time" id="exchange_time" name="exchange_time" value="<?php echo date('H:i'); ?>">
                        </div>
                    </div>
                </div>
                
                <div style="text-align: center; margin-top: 2rem;">
                    <button type="submit" name="finalize_sale" class="btn btn-success" style="font-size: 1.1rem; padding: 1rem 2rem;">
                        ✅ Finalizar Venta
                    </button>
                    <a href="index.php?action=ventas&method=new" class="btn btn-secondary">🔄 Limpiar Carrito</a>
                </div>
            </form>
        </div>

    <?php else: ?>
        <div style="text-align: center; padding: 3rem; color: #7f8c8d;">
            <p style="font-size: 1.2rem;">🛒 El carrito está vacío</p>
            <p>Agrega productos para comenzar una nueva venta</p>
        </div>
    <?php endif; ?>
</div>

<script>
// Búsqueda de clientes
document.getElementById('client_search').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const select = document.getElementById('cedula_rif');
    const options = select.options;
    
    for (let i = 1; i < options.length; i++) {
        const text = options[i].text.toLowerCase();
        options[i].style.display = text.includes(searchTerm) ? '' : 'none';
    }
});

// Búsqueda de productos
document.getElementById('product_search').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const select = document.getElementById('product_id');
    const options = select.options;
    
    for (let i = 1; i < options.length; i++) {
        const text = options[i].text.toLowerCase();
        options[i].style.display = text.includes(searchTerm) ? '' : 'none';
    }
});

// Mostrar información del producto seleccionado
document.getElementById('product_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const productInfo = document.getElementById('product-info');
    
    if (selectedOption.value) {
        const price = parseFloat(selectedOption.dataset.price);
        const stock = parseInt(selectedOption.dataset.stock);
        
        document.getElementById('product-price').textContent = price.toFixed(2);
        document.getElementById('product-stock').textContent = stock;
        document.getElementById('quantity').max = stock;
        
        updateSubtotal();
        productInfo.style.display = 'block';
    } else {
        productInfo.style.display = 'none';
    }
});

// Actualizar subtotal
function updateSubtotal() {
    const select = document.getElementById('product_id');
    const quantity = document.getElementById('quantity');
    const subtotalSpan = document.getElementById('subtotal');
    
    if (select.selectedIndex > 0) {
        const price = parseFloat(select.options[select.selectedIndex].dataset.price);
        const qty = parseInt(quantity.value) || 0;
        const subtotal = price * qty;
        
        subtotalSpan.textContent = subtotal.toFixed(2);
    }
}

document.getElementById('quantity').addEventListener('input', updateSubtotal);

// Mostrar campos de tasa de cambio para divisas
document.getElementById('payment_method').addEventListener('change', function() {
    const exchangeFields = document.getElementById('exchange_rate_fields');
    exchangeFields.style.display = this.value === 'Divisas' ? 'block' : 'none';
});

// Validar cantidad antes de enviar
document.querySelector('form').addEventListener('submit', function(e) {
    if (e.submitter && e.submitter.name === 'add_to_cart') {
        const select = document.getElementById('product_id');
        const quantity = document.getElementById('quantity');
        
        if (select.selectedIndex > 0) {
            const maxStock = parseInt(select.options[select.selectedIndex].dataset.stock);
            const requestedQty = parseInt(quantity.value);
            
            if (requestedQty > maxStock) {
                e.preventDefault();
                alert(`Solo hay ${maxStock} unidades disponibles de este producto.`);
                return false;
            }
        }
    }
});
</script>

<?php require_once 'views/layout/footer.php'; ?>
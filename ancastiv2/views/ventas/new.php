<?php require_once 'views/layout/header.php'; ?>

<h2>🛒 Nueva Venta</h2>

<?php if (isset($error)): ?>
    <div class="alert alert-danger">⚠️ <?php echo $error; ?></div>
<?php endif; ?>

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
                                <?php echo $product['Nombre'] . ' - Bs ' . number_format($product['Precio'], 2) . ' - Stock: ' . $product['Cantidad']; ?>
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
            <p><strong>Precio:</strong> Bs <span id="product-price">0.00</span></p>
            <p><strong>Stock disponible:</strong> <span id="product-stock">0</span> unidades</p>
            <p><strong>Subtotal:</strong> Bs <span id="subtotal">0.00</span></p>
        </div>
    </form>
</div>

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
                            <td>Bs <?php echo number_format($item['precio'], 2); ?></td>
                            <td><?php echo $item['cantidad']; ?></td>
                            <td><strong>Bs <?php echo number_format($item['subtotal'], 2); ?></strong></td>
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
            💰 Total de la Venta: Bs <?php echo number_format($total, 2); ?>
        </div>

        <div class="card" style="margin-top: 1.5rem;">
            <h3>💳 Finalizar Venta</h3>
            <form action="index.php?action=ventas&method=new" method="post" id="finalize-form">
                <div class="form-group">
                    <label for="final_cedula_rif">Cliente para la venta:</label>
                    <select id="final_cedula_rif" name="cedula_rif" required>
                        <option value="">Seleccione un cliente</option>
                        <?php foreach ($clients as $client): ?>
                            <option value="<?php echo $client['Cedula_Rif']; ?>">
                                <?php echo $client['Cedula_Rif'] . ' - ' . $client['Nombre'] . ' ' . $client['Apellido']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
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
                        <label for="amount_paid">Monto Pagado (Bs):</label>
                        <input type="number" id="amount_paid" name="amount_paid" step="0.01" min="0" 
                               value="<?php echo $total; ?>" required>
                    </div>
                </div>
                
                <!-- Campos específicos para divisas -->
                <div id="divisas_fields" style="display: none;">
                    <div class="alert alert-info">
                        <strong>💱 Pago en Divisas</strong><br>
                        Complete la información de la tasa de cambio y el monto en divisas.
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="divisas_amount">💵 Monto en Divisas (USD):</label>
                            <input type="number" id="divisas_amount" name="divisas_amount" step="0.01" min="0" 
                                   placeholder="Ej: 10.50">
                            <small style="color: #7f8c8d; font-size: 0.8rem;">
                                Cantidad de dólares que paga el cliente
                            </small>
                        </div>
                        
                        <div class="form-group">
                            <label for="exchange_rate">💱 Tasa de Cambio (Bs por USD):</label>
                            <input type="number" id="exchange_rate" name="exchange_rate" step="0.01" min="0" 
                                   placeholder="Ej: 36.50">
                            <small style="color: #7f8c8d; font-size: 0.8rem;">
                                Cuántos bolívares vale 1 dólar
                            </small>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="exchange_time">🕐 Hora:</label>
                        <input type="time" id="exchange_time" name="exchange_time" value="<?php echo date('H:i'); ?>">
                    </div>
                    
                    <!-- Calculadora de divisas -->
                    <div id="divisas_calculator" style="display: none; background: #f8f9fa; padding: 1.5rem; border-radius: 8px; margin: 1.5rem 0; border-left: 4px solid #3498db;">
                        <h4 style="color: #2c3e50; margin-bottom: 1rem;">🧮 Cálculo de Divisas</h4>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                            <div>
                                <strong>Total a pagar:</strong><br>
                                <span style="color: #3498db; font-size: 1.2rem;">Bs <?php echo number_format($total, 2); ?></span>
                            </div>
                            <div>
                                <strong>Monto en divisas:</strong><br>
                                <span id="calc_divisas_amount" style="color: #27ae60; font-size: 1.2rem;">$0.00</span>
                            </div>
                            <div>
                                <strong>Equivalente en Bs:</strong><br>
                                <span id="calc_bs_equivalent" style="color: #f39c12; font-size: 1.2rem;">Bs 0.00</span>
                            </div>
                            <div>
                                <strong>Vuelto en Bs:</strong><br>
                                <span id="calc_change" style="color: #e74c3c; font-size: 1.2rem; font-weight: bold;">Bs 0.00</span>
                            </div>
                        </div>
                        
                        <div id="change_alert" style="display: none; margin-top: 1rem; padding: 1rem; border-radius: 8px;">
                            <!-- Aquí se mostrará si hay vuelto o si falta dinero -->
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
const saleTotal = <?php echo $total ?? 0; ?>;

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

// Información del producto seleccionado
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

// Manejo del método de pago
document.getElementById('payment_method').addEventListener('change', function() {
    const divisasFields = document.getElementById('divisas_fields');
    const amountPaidField = document.getElementById('amount_paid');
    
    if (this.value === 'Divisas') {
        divisasFields.style.display = 'block';
        amountPaidField.readOnly = true;
        amountPaidField.style.backgroundColor = '#f8f9fa';
        amountPaidField.style.cursor = 'not-allowed';
    } else {
        divisasFields.style.display = 'none';
        amountPaidField.readOnly = false;
        amountPaidField.style.backgroundColor = '';
        amountPaidField.style.cursor = '';
        amountPaidField.value = saleTotal.toFixed(2);
        document.getElementById('divisas_calculator').style.display = 'none';
    }
});

// Calculadora de divisas
function updateDivisasCalculation() {
    const divisasAmount = parseFloat(document.getElementById('divisas_amount').value) || 0;
    const exchangeRate = parseFloat(document.getElementById('exchange_rate').value) || 0;
    const calculator = document.getElementById('divisas_calculator');
    
    if (divisasAmount > 0 && exchangeRate > 0) {
        calculator.style.display = 'block';
        
        const bsEquivalent = divisasAmount * exchangeRate;
        const change = bsEquivalent - saleTotal;
        
        // Actualizar los valores mostrados
        document.getElementById('calc_divisas_amount').textContent = '$' + divisasAmount.toFixed(2);
        document.getElementById('calc_bs_equivalent').textContent = 'Bs ' + bsEquivalent.toFixed(2);
        document.getElementById('calc_change').textContent = 'Bs ' + change.toFixed(2);
        
        // Actualizar el campo de monto pagado
        document.getElementById('amount_paid').value = bsEquivalent.toFixed(2);
        
        // Mostrar alerta según el resultado
        const changeAlert = document.getElementById('change_alert');
        changeAlert.style.display = 'block';
        
        if (change > 0) {
            changeAlert.style.background = '#d4edda';
            changeAlert.style.color = '#155724';
            changeAlert.style.border = '1px solid #c3e6cb';
            changeAlert.innerHTML = `
                <strong>💰 Vuelto a entregar:</strong> Bs ${change.toFixed(2)}<br>
                <small>El cliente paga $${divisasAmount.toFixed(2)} y debe recibir Bs ${change.toFixed(2)} de vuelto</small>
            `;
        } else if (change < 0) {
            changeAlert.style.background = '#f8d7da';
            changeAlert.style.color = '#721c24';
            changeAlert.style.border = '1px solid #f5c6cb';
            changeAlert.innerHTML = `
                <strong>⚠️ Dinero insuficiente:</strong> Faltan Bs ${Math.abs(change).toFixed(2)}<br>
                <small>El cliente necesita pagar $${(saleTotal / exchangeRate).toFixed(2)} para cubrir el total</small>
            `;
        } else {
            changeAlert.style.background = '#d1ecf1';
            changeAlert.style.color = '#0c5460';
            changeAlert.style.border = '1px solid #bee5eb';
            changeAlert.innerHTML = `
                <strong>✅ Pago exacto:</strong> No hay vuelto<br>
                <small>El monto en divisas cubre exactamente el total de la venta</small>
            `;
        }
    } else {
        calculator.style.display = 'none';
    }
}

// Event listeners para la calculadora de divisas
document.getElementById('divisas_amount').addEventListener('input', updateDivisasCalculation);
document.getElementById('exchange_rate').addEventListener('input', updateDivisasCalculation);

// Validación del formulario
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

// Validación del formulario de finalización
document.getElementById('finalize-form').addEventListener('submit', function(e) {
    const clientSelect = document.getElementById('final_cedula_rif');
    const paymentMethod = document.getElementById('payment_method').value;
    
    if (!clientSelect.value) {
        e.preventDefault();
        alert('Debe seleccionar un cliente para finalizar la venta.');
        return false;
    }
    
    // Validaciones específicas para divisas
    if (paymentMethod === 'Divisas') {
        const divisasAmount = parseFloat(document.getElementById('divisas_amount').value) || 0;
        const exchangeRate = parseFloat(document.getElementById('exchange_rate').value) || 0;
        
        if (divisasAmount <= 0) {
            e.preventDefault();
            alert('⚠️ Debe ingresar el monto en divisas que paga el cliente.');
            document.getElementById('divisas_amount').focus();
            return false;
        }
        
        if (exchangeRate <= 0) {
            e.preventDefault();
            alert('⚠️ Debe ingresar la tasa de cambio.');
            document.getElementById('exchange_rate').focus();
            return false;
        }
        
        const bsEquivalent = divisasAmount * exchangeRate;
        const change = bsEquivalent - saleTotal;
        
        // Confirmación con detalles del pago en divisas
        let confirmMessage = `¿Confirmar venta con pago en divisas?\n\n`;
        confirmMessage += `Total de la venta: Bs ${saleTotal.toFixed(2)}\n`;
        confirmMessage += `Cliente paga: $${divisasAmount.toFixed(2)}\n`;
        confirmMessage += `Tasa de cambio: Bs ${exchangeRate.toFixed(2)} por USD\n`;
        confirmMessage += `Equivalente en Bs: Bs ${bsEquivalent.toFixed(2)}\n`;
        
        if (change > 0) {
            confirmMessage += `\n💰 VUELTO A ENTREGAR: Bs ${change.toFixed(2)}`;
        } else if (change < 0) {
            confirmMessage += `\n⚠️ DINERO INSUFICIENTE: Faltan Bs ${Math.abs(change).toFixed(2)}`;
            if (!confirm('El dinero es insuficiente. ¿Desea continuar de todas formas? Esto creará una deuda pendiente.')) {
                e.preventDefault();
                return false;
            }
        } else {
            confirmMessage += `\n✅ PAGO EXACTO: Sin vuelto`;
        }
        
        if (!confirm(confirmMessage)) {
            e.preventDefault();
            return false;
        }
    }
});
</script>

<?php require_once 'views/layout/footer.php'; ?>
<?php require_once 'views/layout/header.php'; ?>

<h2>➕ Agregar Nuevo Producto</h2>

<?php if (isset($error)): ?>
    <div class="alert alert-danger">⚠️ <?php echo $error; ?></div>
<?php endif; ?>

<div class="form-container">
    <form action="index.php?action=productos&method=add" method="post">
        <div class="form-row">
            <div class="form-group">
                <label for="nombre">📦 Nombre del Producto:</label>
                <input type="text" id="nombre" name="nombre" required 
                       placeholder="Ej: Laptop Dell Inspiron 15">
            </div>
            
            <div class="form-group">
                <label for="precio">💰 Precio de Venta (Bs):</label>
                <input type="number" id="precio" name="precio" step="0.01" min="0" required 
                       placeholder="0.00">
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="unidad">📏 Unidad de Medida:</label>
                <select id="unidad" name="unidad" required>
                    <option value="">Seleccione una unidad</option>
                    <option value="Unidad">Unidad</option>
                    <option value="Kilogramo">Kilogramo (Kg)</option>
                    <option value="Gramo">Gramo (g)</option>
                    <option value="Litro">Litro (L)</option>
                    <option value="Metro">Metro (m)</option>
                    <option value="Caja">Caja</option>
                    <option value="Paquete">Paquete</option>
                    <option value="Docena">Docena</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="cantidad">📊 Cantidad Inicial en Stock:</label>
                <input type="number" id="cantidad" name="cantidad" min="0" required 
                       placeholder="0">
            </div>
        </div>
        
        <div class="alert alert-info">
            <strong>💡 Consejo:</strong> Asegúrate de ingresar la información correcta. 
            Podrás editarla más tarde si es necesario.
        </div>
        
        <div style="text-align: center; margin-top: 2rem;">
            <button type="submit" class="btn btn-success" style="font-size: 1.1rem; padding: 1rem 2rem;">
                ✅ Guardar Producto
            </button>
            <a href="index.php?action=productos&method=list" class="btn btn-secondary">
                ❌ Cancelar
            </a>
        </div>
    </form>
</div>

<div class="card" style="margin-top: 2rem;">
    <h3>📋 Información Importante</h3>
    <ul style="color: #7f8c8d; line-height: 2;">
        <li><strong>Nombre:</strong> Usa nombres descriptivos y únicos para cada producto</li>
        <li><strong>Precio:</strong> Ingresa el precio de venta al público en bolívares (Bs)</li>
        <li><strong>Unidad:</strong> Selecciona la unidad de medida apropiada</li>
        <li><strong>Stock:</strong> La cantidad inicial que tienes disponible para vender</li>
    </ul>
</div>

<script>

document.getElementById('precio').addEventListener('input', function() {
    let value = this.value;
    if (value && !isNaN(value)) {
        
        console.log('Precio: Bs ' + parseFloat(value).toFixed(2));
    }
});

document.querySelector('form').addEventListener('submit', function(e) {
    const nombre = document.getElementById('nombre').value.trim();
    const precio = parseFloat(document.getElementById('precio').value);
    const cantidad = parseInt(document.getElementById('cantidad').value);
    
    if (nombre.length < 3) {
        e.preventDefault();
        alert('⚠️ El nombre del producto debe tener al menos 3 caracteres.');
        return false;
    }
    
    if (precio <= 0) {
        e.preventDefault();
        alert('⚠️ El precio debe ser mayor a 0.');
        return false;
    }
    
    if (cantidad < 0) {
        e.preventDefault();
        alert('⚠️ La cantidad no puede ser negativa.');
        return false;
    }
    
  
    if (!confirm(`¿Confirmar registro del producto?\n\nNombre: ${nombre}\nPrecio: Bs ${precio.toFixed(2)}\nCantidad: ${cantidad}`)) {
        e.preventDefault();
        return false;
    }
});
</script>

<?php require_once 'views/layout/footer.php'; ?>
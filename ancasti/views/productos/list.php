<?php require_once 'views/layout/header.php'; ?>

<h2>📦 Gestión de Productos</h2>

<div class="search-container">
    <div class="search-row">
        <div>
            <input type="text" id="product-search" placeholder="🔍 Buscar productos..." 
                   style="margin-bottom: 0;">
        </div>
        <div>
            <a href="index.php?action=productos&method=add" class="btn btn-success">➕ Agregar Producto</a>
        </div>
    </div>
</div>

<?php if (empty($products)): ?>
    <div class="card" style="text-align: center; padding: 3rem;">
        <h3>📦 No hay productos registrados</h3>
        <p style="color: #7f8c8d; margin: 1rem 0;">Comienza agregando tu primer producto al inventario</p>
        <a href="index.php?action=productos&method=add" class="btn btn-success">➕ Agregar Primer Producto</a>
    </div>
<?php else: ?>
    <div class="card">
        <div style="overflow-x: auto;">
            <table id="products-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Unidad</th>
                        <th>Stock</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td><strong>#<?php echo $product['id_producto']; ?></strong></td>
                        <td>
                            <strong><?php echo htmlspecialchars($product['Nombre']); ?></strong>
                        </td>
                        <td><strong>Bs <?php echo number_format($product['Precio'], 2); ?></strong></td>
                        <td><?php echo htmlspecialchars($product['Unidad']); ?></td>
                        <td>
                            <span class="status-indicator <?php 
                                if ($product['Cantidad'] <= 5) echo 'status-low';
                                elseif ($product['Cantidad'] <= 15) echo 'status-medium';
                                else echo 'status-high';
                            ?>">
                                <?php echo $product['Cantidad']; ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($product['Cantidad'] <= 5): ?>
                                <span class="status-indicator status-low">⚠️ Stock Crítico</span>
                            <?php elseif ($product['Cantidad'] <= 15): ?>
                                <span class="status-indicator status-medium">⚡ Stock Bajo</span>
                            <?php else: ?>
                                <span class="status-indicator status-high">✅ Disponible</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="action-links">
                                <a href="index.php?action=productos&method=edit&id=<?php echo $product['id_producto']; ?>" 
                                   class="action-edit">✏️ Editar</a>
                                <a href="index.php?action=productos&method=delete&id=<?php echo $product['id_producto']; ?>" 
                                   class="action-delete"
                                   onclick="return confirm('⚠️ ¿Estás seguro de eliminar este producto?\n\nEsta acción no se puede deshacer.')">
                                   🗑️ Eliminar</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="stats-grid" style="margin-top: 2rem;">
        <div class="stat-card">
            <span class="stat-number"><?php echo count($products); ?></span>
            <span class="stat-label">📦 Total Productos</span>
        </div>
        <div class="stat-card">
            <span class="stat-number"><?php echo count(array_filter($products, function($p) { return $p['Cantidad'] > 15; })); ?></span>
            <span class="stat-label">✅ Stock Bueno</span>
        </div>
        <div class="stat-card">
            <span class="stat-number" style="color: #f39c12;"><?php echo count(array_filter($products, function($p) { return $p['Cantidad'] <= 15 && $p['Cantidad'] > 5; })); ?></span>
            <span class="stat-label">⚡ Stock Bajo</span>
        </div>
        <div class="stat-card">
            <span class="stat-number" style="color: #e74c3c;"><?php echo count(array_filter($products, function($p) { return $p['Cantidad'] <= 5; })); ?></span>
            <span class="stat-label">⚠️ Stock Crítico</span>
        </div>
    </div>
<?php endif; ?>

<script>

document.getElementById('product-search').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const table = document.getElementById('products-table');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    
    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const productName = row.cells[1].textContent.toLowerCase();
        const productId = row.cells[0].textContent.toLowerCase();
        
        if (productName.includes(searchTerm) || productId.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    }
});
</script>

<?php require_once 'views/layout/footer.php'; ?>
<?php require_once 'views/layout/header.php'; ?>

<h2>📊 Lista de Ventas</h2>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success">✅ <?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger">⚠️ <?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>

<div class="search-container">
    <div class="search-row">
        <div>
            <input type="text" id="sales-search" placeholder="🔍 Buscar ventas por cliente o ID..." 
                   style="margin-bottom: 0;">
        </div>
        <div>
            <a href="index.php?action=ventas&method=new" class="btn btn-success">🛒 Nueva Venta</a>
        </div>
    </div>
</div>

<?php if (empty($sales)): ?>
    <div class="card" style="text-align: center; padding: 3rem;">
        <h3>📊 No hay ventas registradas</h3>
        <p style="color: #7f8c8d; margin: 1rem 0;">Comienza registrando tu primera venta</p>
        <a href="index.php?action=ventas&method=new" class="btn btn-success">🛒 Registrar Primera Venta</a>
    </div>
<?php else: ?>
    <div class="card">
        <div style="overflow-x: auto;">
            <table id="sales-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Cédula/RIF</th>
                        <th>Total</th>
                        <th>Estado Pago</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sales as $sale): ?>
                    <tr>
                        <td><strong>#<?php echo $sale['id_venta']; ?></strong></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($sale['Fecha_Emision'])); ?></td>
                        <td><strong><?php echo htmlspecialchars($sale['Nombre'] . ' ' . $sale['Apellido']); ?></strong></td>
                        <td><?php echo htmlspecialchars($sale['Cedula_Rif']); ?></td>
                        <td><strong style="color: #27ae60;">Bs <?php echo number_format($sale['Total'], 2); ?></strong></td>
                        <td>
                            <?php if ($sale['Estado_Pago'] === 'Pagado'): ?>
                                <span class="status-indicator status-high">✅ Pagado</span>
                            <?php else: ?>
                                <span class="status-indicator status-low">⚠️ No Pagado</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="action-links">
                                <a href="index.php?action=ventas&method=details&id=<?php echo $sale['id_venta']; ?>" 
                                   class="action-view">👁️ Detalles</a>
                                
                                <?php 
                                // Solo mostrar eliminar para administradores
                                $isAdmin = isset($_SESSION['rol_nombre']) && strtolower($_SESSION['rol_nombre']) === 'administrador';
                                if ($isAdmin): 
                                ?>
                                <a href="index.php?action=ventas&method=delete&id=<?php echo $sale['id_venta']; ?>" 
                                   class="action-delete"
                                   onclick="return confirm('⚠️ ¿Estás seguro de eliminar esta venta?\n\n• Se restaurará el stock de los productos\n• Esta acción no se puede deshacer\n• ID Venta: #<?php echo $sale['id_venta']; ?>\n• Cliente: <?php echo htmlspecialchars($sale['Nombre'] . ' ' . $sale['Apellido']); ?>\n• Total: Bs <?php echo number_format($sale['Total'], 2); ?>')">
                                   🗑️ Eliminar</a>
                                <?php endif; ?>
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
            <span class="stat-number"><?php echo count($sales); ?></span>
            <span class="stat-label">📊 Total Ventas</span>
        </div>
        <div class="stat-card">
            <span class="stat-number">Bs <?php echo number_format(array_sum(array_column($sales, 'Total')), 2); ?></span>
            <span class="stat-label">💰 Total Facturado</span>
        </div>
        <div class="stat-card">
            <span class="stat-number" style="color: #27ae60;"><?php echo count(array_filter($sales, function($s) { return $s['Estado_Pago'] === 'Pagado'; })); ?></span>
            <span class="stat-label">✅ Ventas Pagadas</span>
        </div>
        <div class="stat-card">
            <span class="stat-number" style="color: #e74c3c;"><?php echo count(array_filter($sales, function($s) { return $s['Estado_Pago'] === 'No Pagado'; })); ?></span>
            <span class="stat-label">⚠️ Ventas No Pagadas</span>
        </div>
    </div>

    <?php if (!$isAdmin): ?>
    <div class="alert alert-info" style="margin-top: 2rem;">
        <strong>💡 Información:</strong> Solo los administradores pueden eliminar ventas. 
        Como vendedor, puedes ver los detalles de todas las ventas registradas.
    </div>
    <?php endif; ?>
<?php endif; ?>

<script>
document.getElementById('sales-search').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const table = document.getElementById('sales-table');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    
    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const saleId = row.cells[0].textContent.toLowerCase();
        const clientName = row.cells[2].textContent.toLowerCase();
        const clientId = row.cells[3].textContent.toLowerCase();
        
        if (saleId.includes(searchTerm) || clientName.includes(searchTerm) || clientId.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    }
});
</script>

<?php require_once 'views/layout/footer.php'; ?>
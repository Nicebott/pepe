<?php require_once 'views/layout/header.php'; ?>

<h2>👥 Lista de Clientes</h2>

<div class="search-container">
    <div class="search-row">
        <div>
            <input type="text" id="client-search" placeholder="🔍 Buscar clientes por cédula, nombre o teléfono..." 
                   style="margin-bottom: 0;">
        </div>
        <div>
            <a href="index.php?action=clientes&method=add" class="btn btn-success">➕ Agregar Cliente</a>
        </div>
    </div>
</div>

<?php if (empty($clients)): ?>
    <div class="card" style="text-align: center; padding: 3rem;">
        <h3>👥 No hay clientes registrados</h3>
        <p style="color: #7f8c8d; margin: 1rem 0;">Comienza agregando tu primer cliente</p>
        <a href="index.php?action=clientes&method=add" class="btn btn-success">➕ Agregar Primer Cliente</a>
    </div>
<?php else: ?>
    <div class="card">
        <div style="overflow-x: auto;">
            <table id="clients-table">
                <thead>
                    <tr>
                        <th>Cédula/RIF</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clients as $client): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($client['Cedula_Rif']); ?></strong></td>
                        <td><strong><?php echo htmlspecialchars($client['Nombre']); ?></strong></td>
                        <td><?php echo htmlspecialchars($client['Apellido']); ?></td>
                        <td><?php echo htmlspecialchars($client['Telefono']); ?></td>
                        <td><?php echo htmlspecialchars($client['Correo']); ?></td>
                        <td>
                            <div class="action-links">
                                <a href="index.php?action=clientes&method=edit&id=<?php echo urlencode($client['Cedula_Rif']); ?>" 
                                   class="action-edit">✏️ Editar</a>
                                <a href="index.php?action=clientes&method=delete&id=<?php echo urlencode($client['Cedula_Rif']); ?>" 
                                   class="action-delete"
                                   onclick="return confirm('⚠️ ¿Estás seguro de eliminar este cliente?\n\nCliente: <?php echo htmlspecialchars($client['Nombre'] . ' ' . $client['Apellido']); ?>\nCédula/RIF: <?php echo htmlspecialchars($client['Cedula_Rif']); ?>\n\nEsta acción no se puede deshacer.')">
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
            <span class="stat-number"><?php echo count($clients); ?></span>
            <span class="stat-label">👥 Total Clientes</span>
        </div>
        <div class="stat-card">
            <span class="stat-number"><?php echo count(array_filter($clients, function($c) { return !empty($c['Telefono']); })); ?></span>
            <span class="stat-label">📱 Con Teléfono</span>
        </div>
        <div class="stat-card">
            <span class="stat-number"><?php echo count(array_filter($clients, function($c) { return !empty($c['Correo']); })); ?></span>
            <span class="stat-label">📧 Con Email</span>
        </div>
        <div class="stat-card">
            <span class="stat-number"><?php echo count(array_filter($clients, function($c) { return strpos($c['Cedula_Rif'], 'J') === 0; })); ?></span>
            <span class="stat-label">🏢 Empresas (RIF)</span>
        </div>
    </div>
<?php endif; ?>

<script>

document.getElementById('client-search').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const table = document.getElementById('clients-table');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    
    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const cedula = row.cells[0].textContent.toLowerCase();
        const nombre = row.cells[1].textContent.toLowerCase();
        const apellido = row.cells[2].textContent.toLowerCase();
        const telefono = row.cells[3].textContent.toLowerCase();
        const correo = row.cells[4].textContent.toLowerCase();
        
        if (cedula.includes(searchTerm) || 
            nombre.includes(searchTerm) || 
            apellido.includes(searchTerm) || 
            telefono.includes(searchTerm) || 
            correo.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    }
});

document.addEventListener('DOMContentLoaded', function() {
    
    const rows = document.querySelectorAll('#clients-table tbody tr');
    rows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#f8f9fa';
            this.style.transform = 'scale(1.01)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
            this.style.transform = '';
        });
    });
});
</script>

<?php require_once 'views/layout/footer.php'; ?>
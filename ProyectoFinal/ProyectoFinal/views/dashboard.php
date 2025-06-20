<?php
// views/dashboard.php
require_once 'views/layout/header.php';
?>

<h2>Panel Principal</h2>
<p>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?></p>

<div class="dashboard-sections">
    <section class="quick-actions">
        <h3>Acciones Rápidas</h3>
        <ul>
            <li><a href="index.php?action=ventas&method=new">Nueva Venta</a></li>
            <li><a href="index.php?action=productos&method=list">Ver Productos</a></li>
            <li><a href="index.php?action=clientes&method=list">Ver Clientes</a></li>
        </ul>
    </section>
</div>

<?php
require_once 'views/layout/footer.php';
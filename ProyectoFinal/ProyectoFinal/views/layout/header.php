<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Control de Ventas</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <h1>Sistema de Control de Ventas</h1>
        <nav>
            <?php if (isset($_SESSION['id_usuario'])): ?>
                <a href="index.php?action=dashboard">Inicio</a>
                <a href="index.php?action=productos&method=list">Productos</a>
                <a href="index.php?action=clientes&method=list">Clientes</a>
                <a href="index.php?action=ventas&method=new">Nueva Venta</a>
                <a href="index.php?action=ventas&method=list">Ventas</a>
                <a href="index.php?action=reportes&method=salesByDate">Reportes</a>
                <a href="index.php?action=logout">Cerrar Sesión</a>
            <?php endif; ?>
        </nav>
    </header>
    <main>
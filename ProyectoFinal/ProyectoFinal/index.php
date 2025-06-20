<?php
session_start();

// Configuración básica
define('BASE_PATH', __DIR__);

// Cargar configuración de la base de datos
require_once 'config/database.php';

// Cargar controladores
require_once 'controllers/AuthController.php';
require_once 'controllers/SaleController.php';
require_once 'controllers/ProductController.php';
require_once 'controllers/ClientController.php';
require_once 'controllers/ReportController.php';

// Manejar acción por defecto
$action = $_GET['action'] ?? 'login';

// Redirigir a ventas si ya está logueado y pide login
if ($action === 'login' && isset($_SESSION['id_usuario'])) {
    header('Location: index.php?action=ventas&method=new');
    exit;
}

// Enrutamiento principal
switch ($action) {
    case 'login':
    case 'logout':
        $controller = new AuthController();
        $method = $action;
        break;
        
    case 'productos':
        $controller = new ProductController();
        $method = $_GET['method'] ?? 'list';
        break;
        
    case 'clientes':
        $controller = new ClientController();
        $method = $_GET['method'] ?? 'list';
        break;
        
    case 'ventas':
        $controller = new SaleController();
        $method = $_GET['method'] ?? 'new';
        break;
        
    case 'reportes':
        $controller = new ReportController();
        $method = $_GET['method'] ?? 'salesByDate';
        break;
        
    default:
        // Redirigir a ventas como página principal
        header('Location: index.php?action=ventas&method=new');
        exit;
}

// Verificar autenticación (excepto para login)
if ($action !== 'login') {
    AuthController::checkAuth();
}

// Ejecutar la acción
if (method_exists($controller, $method)) {
    $controller->$method();
} else {
    header('HTTP/1.0 404 Not Found');
    echo 'Método no encontrado';
}
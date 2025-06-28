<?php
session_start();

define('BASE_PATH', __DIR__);


require_once 'config/database.php';


require_once 'controllers/AuthController.php';
require_once 'controllers/WelcomeController.php';
require_once 'controllers/PanelController.php';
require_once 'controllers/DashboardController.php';
require_once 'controllers/SaleController.php';
require_once 'controllers/ProductController.php';
require_once 'controllers/ClientController.php';
require_once 'controllers/ReportController.php';


$action = $_GET['action'] ?? 'login';


if ($action === 'check_session') {
    header('Content-Type: application/json');
    echo json_encode(['authenticated' => AuthController::isAuthenticated()]);
    exit;
}


if ($action === 'login' && isset($_SESSION['id_usuario'])) {
    header('Location: index.php?action=welcome');
    exit;
}


switch ($action) {
    case 'login':
    case 'logout':
        $controller = new AuthController();
        $method = $action;
        break;
        
    case 'welcome':
        $controller = new WelcomeController();
        $method = 'index';
        break;
        
    case 'panel':
        $controller = new PanelController();
        $method = 'index';
        break;
        
    case 'dashboard':
        // Redirigir el pepe
        header('Location: index.php?action=welcome');
        exit;
        
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
        
        header('Location: index.php?action=welcome');
        exit;
}


if ($action !== 'login' && $action !== 'check_session') {
    AuthController::checkAuth();
}


if (method_exists($controller, $method)) {
    $controller->$method();
} else {
    header('HTTP/1.0 404 Not Found');
    echo 'Método no encontrado';
}
?>
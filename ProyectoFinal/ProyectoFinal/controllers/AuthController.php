<?php
// controllers/AuthController.php

require_once 'models/UserModel.php';
require_once 'models/RolModel.php';

class AuthController {
    private $userModel;
    private $rolModel;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->userModel = new UserModel($db);
        $this->rolModel = new RolModel($db);
    }

    public function login() {
        // Si ya está autenticado, redirigir según su rol
        if (self::isAuthenticated()) {
            $this->redirectBasedOnRole($_SESSION['id_rol']);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_usuario = $_POST['id_usuario'] ?? '';
            $contraseña = $_POST['contraseña'] ?? '';
            
            $user = $this->userModel->getUserById($id_usuario);
            
            if ($user && $user['Contraseña'] === $contraseña) {
                $_SESSION['id_usuario'] = $user['id_usuario'];
                $_SESSION['cedula'] = $user['Cedula'];
                $_SESSION['nombre'] = $user['Nombre'];
                $_SESSION['apellido'] = $user['Apellido'];
                $_SESSION['id_rol'] = $user['id_rol'];
                
                $role = $this->rolModel->getRoleById($user['id_rol']);
                $_SESSION['rol_nombre'] = $role['Nombre'];
                
                $this->userModel->updateLastLogin($user['Cedula']);
                
                $this->redirectBasedOnRole($user['id_rol']);
                return;
            } else {
                $_SESSION['error'] = "Credenciales incorrectas";
            }
        }
        
        require_once 'views/auth/login.php';
    }

    public function logout() {
        if (isset($_SESSION['cedula'])) {
            $this->userModel->registerLogout($_SESSION['cedula']);
        }
        
        session_destroy();
        header('Location: index.php?action=login');
        exit;
    }

    private function redirectBasedOnRole($id_rol) {
        $role = $this->rolModel->getRoleById($id_rol);
        $location = 'index.php?action=dashboard'; // Ruta por defecto
        
        switch(strtolower($role['Nombre'])) {
            case 'administrador':
                $location = 'index.php?action=dashboard';
                break;
            case 'vendedor':
                $location = 'index.php?action=ventas&method=new';
                break;
        }
        
        header("Location: $location");
        exit;
    }

    public static function isAuthenticated() {
        return isset($_SESSION['id_usuario']);
    }

    public static function checkAuth($requiredRoles = []) {
        if (!self::isAuthenticated()) {
            header('Location: index.php?action=login');
            exit;
        }
        
        if (!empty($requiredRoles) && !in_array($_SESSION['id_rol'], $requiredRoles)) {
            header('Location: index.php?action=unauthorized');
            exit;
        }
    }
}
?>
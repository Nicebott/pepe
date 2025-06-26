<?php
require_once 'models/ClientModel.php';

class ClientController {
    private $clientModel;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->clientModel = new ClientModel($db);
    }

    public function index() {
        $this->list();
    }

    public function list() {
        $clients = $this->clientModel->getAllClients();
        require_once 'views/clientes/list.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cedula_rif = $_POST['cedula_rif'];
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $telefono = $_POST['telefono'];
            $direccion = $_POST['direccion'];
            $correo = $_POST['correo'];

            if ($this->clientModel->createClient($cedula_rif, $nombre, $apellido, $telefono, $direccion, $correo)) {
                header('Location: index.php?action=clientes&method=list');
                exit;
            } else {
                $error = "Error al crear el cliente";
                require_once 'views/clientes/add.php';
            }
        } else {
            require_once 'views/clientes/add.php';
        }
    }

    public function edit() {
        if (!isset($_GET['id'])) {
            header('Location: index.php?action=clientes&method=list');
            exit;
        }

        $cedula_rif = $_GET['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $telefono = $_POST['telefono'];
            $direccion = $_POST['direccion'];
            $correo = $_POST['correo'];

            if ($this->clientModel->updateClient($cedula_rif, $nombre, $apellido, $telefono, $direccion, $correo)) {
                header('Location: index.php?action=clientes&method=list');
                exit;
            } else {
                $error = "Error al actualizar el cliente";
                $client = $this->clientModel->getClient($cedula_rif);
                require_once 'views/clientes/edit.php';
            }
        } else {
            $client = $this->clientModel->getClient($cedula_rif);
            require_once 'views/clientes/edit.php';
        }
    }

    public function delete() {
        if (isset($_GET['id'])) {
            $cedula_rif = $_GET['id'];
            $this->clientModel->deleteClient($cedula_rif);
        }
        header('Location: index.php?action=clientes&method=list');
        exit;
    }
}
?>
<?php
require_once 'models/ProductModel.php';
require_once 'models/StockModel.php';

class ProductController {
    private $productModel;
    private $stockModel;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->productModel = new ProductModel($db);
        $this->stockModel = new StockModel($db);
    }

    public function index() {
        $this->list();
    }

    public function list() {
        $products = $this->productModel->getAllProductsWithStock();
        require_once 'views/productos/list.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $precio = $_POST['precio'];
            $unidad = $_POST['unidad'];
            $cantidad = $_POST['cantidad'];

            // Iniciar transacción
            $this->productModel->beginTransaction();
            
            try {
                $productId = $this->productModel->createProduct($nombre, $precio, $unidad);
                $this->stockModel->createStock($productId, $cantidad);
                
                $this->productModel->commit();
                header('Location: index.php?action=productos&method=list');
                exit;
            } catch (Exception $e) {
                $this->productModel->rollBack();
                $error = "Error al crear el producto: " . $e->getMessage();
                require_once 'views/productos/add.php';
            }
        } else {
            require_once 'views/productos/add.php';
        }
    }

    public function edit() {
        if (!isset($_GET['id'])) {
            header('Location: index.php?action=productos&method=list');
            exit;
        }

        $id = $_GET['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $precio = $_POST['precio'];
            $unidad = $_POST['unidad'];
            $cantidad = $_POST['cantidad'];

            $this->productModel->beginTransaction();
            
            try {
                $this->productModel->updateProduct($id, $nombre, $precio, $unidad);
                $this->stockModel->updateStock($id, $cantidad);
                
                $this->productModel->commit();
                header('Location: index.php?action=productos&method=list');
                exit;
            } catch (Exception $e) {
                $this->productModel->rollBack();
                $error = "Error al actualizar el producto: " . $e->getMessage();
                $product = $this->productModel->getProductWithStock($id);
                require_once 'views/productos/edit.php';
            }
        } else {
            $product = $this->productModel->getProductWithStock($id);
            require_once 'views/productos/edit.php';
        }
    }

    public function delete() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $this->productModel->beginTransaction();
            
            try {
                $this->stockModel->deleteStockByProduct($id);
                $this->productModel->deleteProduct($id);
                
                $this->productModel->commit();
            } catch (Exception $e) {
                $this->productModel->rollBack();
            }
        }
        
        header('Location: index.php?action=productos&method=list');
        exit;
    }
}
?>
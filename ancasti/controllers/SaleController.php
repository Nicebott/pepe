<?php
require_once 'models/SaleModel.php';
require_once 'models/SaleDetailModel.php';
require_once 'models/PaymentModel.php';
require_once 'models/PaymentDetailModel.php';
require_once 'models/ExchangeRateModel.php';
require_once 'models/ClientModel.php';
require_once 'models/ProductModel.php';
require_once 'models/StockModel.php';

class SaleController {
    private $saleModel;
    private $saleDetailModel;
    private $paymentModel;
    private $paymentDetailModel;
    private $exchangeRateModel;
    private $clientModel;
    private $productModel;
    private $stockModel;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        
        $this->saleModel = new SaleModel($db);
        $this->saleDetailModel = new SaleDetailModel($db);
        $this->paymentModel = new PaymentModel($db);
        $this->paymentDetailModel = new PaymentDetailModel($db);
        $this->exchangeRateModel = new ExchangeRateModel($db);
        $this->clientModel = new ClientModel($db);
        $this->productModel = new ProductModel($db);
        $this->stockModel = new StockModel($db);
    }

    public function new() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['add_to_cart'])) {
                $this->addToCart();
            } elseif (isset($_POST['remove_item'])) {
                $this->removeFromCart();
            } elseif (isset($_POST['finalize_sale'])) {
                $this->finalizeSale();
            }
        } else {
            $this->showNewSaleForm();
        }
    }

    private function addToCart() {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $productId = $_POST['product_id'];
        $quantity = $_POST['quantity'];
        
        $product = $this->productModel->getProductWithStock($productId);
        
        if ($product && $quantity > 0 && $quantity <= $product['Cantidad']) {
            $item = [
                'id_producto' => $product['id_producto'],
                'nombre' => $product['Nombre'],
                'precio' => $product['Precio'],
                'cantidad' => $quantity,
                'subtotal' => $product['Precio'] * $quantity
            ];
            
            // Buscar si el producto ya está en el carrito
            $found = false;
            foreach ($_SESSION['cart'] as &$cartItem) {
                if ($cartItem['id_producto'] == $productId) {
                    $cartItem['cantidad'] += $quantity;
                    $cartItem['subtotal'] = $cartItem['precio'] * $cartItem['cantidad'];
                    $found = true;
                    break;
                }
            }
            
            if (!$found) {
                $_SESSION['cart'][] = $item;
            }
        }
        
        $this->showNewSaleForm();
    }

    private function removeFromCart() {
        if (isset($_SESSION['cart'])) {
            $index = $_POST['item_index'];
            if (isset($_SESSION['cart'][$index])) {
                unset($_SESSION['cart'][$index]);
                $_SESSION['cart'] = array_values($_SESSION['cart']);
            }
        }
        $this->showNewSaleForm();
    }

    private function finalizeSale() {
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            $this->showNewSaleForm();
            return;
        }

        $cedulaRif = $_POST['cedula_rif'];
        $total = array_sum(array_column($_SESSION['cart'], 'subtotal'));
        $paymentMethod = $_POST['payment_method'];
        $amountPaid = $_POST['amount_paid'];
        $exchangeRate = isset($_POST['exchange_rate']) ? $_POST['exchange_rate'] : null;
        $exchangeTime = isset($_POST['exchange_time']) ? $_POST['exchange_time'] : null;

        $this->saleModel->beginTransaction();
        
        try {
            // Crear la venta
            $saleId = $this->saleModel->createSale($cedulaRif, $total);
            
            // Agregar los detalles de la venta
            foreach ($_SESSION['cart'] as $item) {
                $this->saleDetailModel->createSaleDetail($saleId, $item['id_producto'], $item['cantidad'], $item['precio']);
                
                // Actualizar el stock
                $currentStock = $this->stockModel->getStockByProduct($item['id_producto']);
                $newQuantity = $currentStock['Cantidad'] - $item['cantidad'];
                $this->stockModel->updateStock($item['id_producto'], $newQuantity);
            }
            
            // Registrar el pago
            $paymentId = $this->paymentModel->createPayment($saleId, $amountPaid);
            $paymentDetailId = $this->paymentDetailModel->createPaymentDetail(
                $paymentId, 
                $amountPaid, 
                $paymentMethod
            );
            
            // Registrar tasa de cambio si aplica
            if ($exchangeRate && $exchangeTime) {
                $this->exchangeRateModel->createExchangeRate(
                    $paymentDetailId, 
                    $exchangeRate, 
                    $exchangeTime
                );
            }
            
            $this->saleModel->commit();
            unset($_SESSION['cart']);
            header('Location: index.php?action=ventas&method=list');
            exit;
        } catch (Exception $e) {
            $this->saleModel->rollBack();
            $error = "Error al procesar la venta: " . $e->getMessage();
            $this->showNewSaleForm($error);
        }
    }

    private function showNewSaleForm($error = null) {
        $clients = $this->clientModel->getAllClients();
        $products = $this->productModel->getAllProductsWithStock();
        
        require_once 'views/ventas/new.php';
    }

    public function list() {
        $sales = $this->saleModel->getAllSalesWithClient();
        require_once 'views/ventas/list.php';
    }

    public function details() {
        if (!isset($_GET['id'])) {
            header('Location: index.php?action=ventas&method=list');
            exit;
        }

        $saleId = $_GET['id'];
        $sale = $this->saleModel->getSaleWithClient($saleId);
        $saleDetails = $this->saleDetailModel->getDetailsBySale($saleId);
        $payments = $this->paymentModel->getPaymentsBySale($saleId);
        
        $paymentDetails = [];
        foreach ($payments as $payment) {
            $paymentDetails[$payment['id_pago_venta']] = $this->paymentDetailModel->getDetailsByPayment($payment['id_pago_venta']);
        }
        
        require_once 'views/ventas/details.php';
    }
}
?>
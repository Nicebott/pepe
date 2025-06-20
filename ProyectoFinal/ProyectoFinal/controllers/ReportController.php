<?php
require_once 'models/SaleModel.php';
require_once 'models/SaleDetailModel.php';
require_once 'models/ProductModel.php';
require_once 'models/StockModel.php';

class ReportController {
    private $saleModel;
    private $saleDetailModel;
    private $productModel;
    private $stockModel;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        
        $this->saleModel = new SaleModel($db);
        $this->saleDetailModel = new SaleDetailModel($db);
        $this->productModel = new ProductModel($db);
        $this->stockModel = new StockModel($db);
    }

    public function salesByDate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $startDate = $_POST['start_date'];
            $endDate = $_POST['end_date'];
            
            $sales = $this->saleModel->getSalesByDateRange($startDate, $endDate);
            $total = array_sum(array_column($sales, 'Total'));
            
            require_once 'views/reports/sales_by_date.php';
        } else {
            require_once 'views/reports/sales_by_date.php';
        }
    }

    public function topProducts() {
        $products = $this->saleDetailModel->getTopSellingProducts();
        require_once 'views/reports/top_products.php';
    }

    public function lowStock() {
        $threshold = isset($_GET['threshold']) ? $_GET['threshold'] : 10;
        $products = $this->productModel->getProductsWithLowStock($threshold);
        require_once 'views/reports/low_stock.php';
    }
}
?>
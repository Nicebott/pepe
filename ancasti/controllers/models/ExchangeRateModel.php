<?php
class ExchangeRateModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function createExchangeRate($paymentDetailId, $rate, $time) {
        $query = "INSERT INTO TasaCambio (id_detalle_pago, Precio, Hora) 
                  VALUES (:payment_detail_id, :rate, :time)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':payment_detail_id', $paymentDetailId);
        $stmt->bindParam(':rate', $rate);
        $stmt->bindParam(':time', $time);
        $stmt->execute();
    }

    public function deleteByPaymentDetails($saleId) {
        $query = "DELETE tc FROM TasaCambio tc 
                  JOIN DetallePago dp ON tc.id_detalle_pago = dp.id_detalle_pago 
                  JOIN Pago p ON dp.id_pago_venta = p.id_pago_venta 
                  WHERE p.id_venta = :sale_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':sale_id', $saleId);
        return $stmt->execute();
    }
}
?>
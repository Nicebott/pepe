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
}
?>
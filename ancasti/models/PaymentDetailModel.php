<?php
class PaymentDetailModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function createPaymentDetail($paymentId, $amount, $method) {
        $query = "INSERT INTO DetallePago (id_pago_venta, Monto, Metodo_Pago) 
                  VALUES (:payment_id, :amount, :method)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':payment_id', $paymentId);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':method', $method);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function getDetailsByPayment($paymentId) {
        $query = "SELECT * FROM DetallePago WHERE id_pago_venta = :payment_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':payment_id', $paymentId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
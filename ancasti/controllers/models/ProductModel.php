<?php
class ProductModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function beginTransaction() {
        $this->conn->beginTransaction();
    }

    public function commit() {
        $this->conn->commit();
    }

    public function rollBack() {
        $this->conn->rollBack();
    }

    public function getAllProductsWithStock() {
        $query = "SELECT p.*, COALESCE(s.Cantidad, 0) as Cantidad 
                  FROM Producto p 
                  LEFT JOIN Stock s ON p.id_producto = s.id_producto
                  ORDER BY p.Nombre ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductWithStock($id) {
        $query = "SELECT p.*, COALESCE(s.Cantidad, 0) as Cantidad 
                  FROM Producto p 
                  LEFT JOIN Stock s ON p.id_producto = s.id_producto
                  WHERE p.id_producto = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getProductsWithLowStock($threshold = 10) {
        $query = "SELECT p.*, COALESCE(s.Cantidad, 0) as Cantidad 
                  FROM Producto p 
                  LEFT JOIN Stock s ON p.id_producto = s.id_producto
                  WHERE COALESCE(s.Cantidad, 0) <= :threshold
                  ORDER BY s.Cantidad ASC, p.Nombre ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':threshold', $threshold);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createProduct($nombre, $precio, $unidad) {
        $query = "INSERT INTO Producto (Nombre, Precio, Unidad) VALUES (:nombre, :precio, :unidad)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':unidad', $unidad);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function updateProduct($id, $nombre, $precio, $unidad) {
        $query = "UPDATE Producto SET Nombre = :nombre, Precio = :precio, Unidad = :unidad 
                  WHERE id_producto = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':unidad', $unidad);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function deleteProduct($id) {
        $query = "DELETE FROM Producto WHERE id_producto = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function searchProducts($searchTerm) {
        $query = "SELECT p.*, COALESCE(s.Cantidad, 0) as Cantidad 
                  FROM Producto p 
                  LEFT JOIN Stock s ON p.id_producto = s.id_producto
                  WHERE p.Nombre LIKE :search OR p.id_producto LIKE :search
                  ORDER BY p.Nombre ASC";
        $stmt = $this->conn->prepare($query);
        $searchTerm = "%{$searchTerm}%";
        $stmt->bindParam(':search', $searchTerm);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
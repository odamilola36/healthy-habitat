<?php

class ProductModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllProducts() {
        // $sql = "SELECT * FROM products";
        // $result = $this->db->query($sql);

        // if ($result) {
        //     return $result->fetch_all(MYSQLI_ASSOC);
        // } else {
        //     return [];
        // }
        return [];
    }

    public function getProductById($id) {
        $sql = "SELECT * FROM products WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);  
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    }

    public function createProduct($name, $description, $category, $price, $health_benefits, $certifications, $business_id) {
        $sql = "INSERT INTO products (name, description, category, price, health_benefits, certifications, business_id)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssssdsi", $name, $description, $category, $price, $health_benefits, $certifications, $business_id);
        
        return $stmt->execute();  
    }

    public function updateProduct($id, $name, $description, $category, $price, $health_benefits, $certifications) {
        $sql = "UPDATE products 
                SET name = ?, description = ?, category = ?, price = ?, health_benefits = ?, certifications = ?
                WHERE id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssssssi", $name, $description, $category, $price, $health_benefits, $certifications, $id);
        
        return $stmt->execute();  // Return true if successful, false otherwise
    }

    public function deleteProduct($id) {
        $sql = "DELETE FROM products WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        
        return $stmt->execute(); 
    }
}

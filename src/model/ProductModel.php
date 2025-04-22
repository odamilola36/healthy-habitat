<?php

class ProductModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllProducts()
    {
        $sql = "SELECT * FROM products";
        $result = $this->db->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllProductsForBusiness($business_id)
    {
        $sql = "SELECT * FROM products where business_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $business_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllCategories()
    {
        $sql = "SELECT * FROM product_category";
        $result = $this->db->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductById($id)
    {
        $sql = "SELECT * FROM products WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function createProduct($name, $description, $category, $price, $health_benefits, $certifications, $type, $quantity, $image_name, $business_id, $prod_cat_id)
    {
        $sql = "INSERT INTO products (name, description, pricing_category, price, health_benefits, certifications, product_type, quantity, image_name, business_id, prod_cat_id)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sssdsssisii", $name, $description, $category, $price, $health_benefits, $certifications, $type, $quantity, $image_name, $business_id, $prod_cat_id);

        return $stmt->execute();
    }

    public function updateProduct($id, $name, $description, $category, $price, $health_benefits, $certifications)
    {
        $sql = "UPDATE products 
                SET name = ?, description = ?, category = ?, price = ?, health_benefits = ?, certifications = ?
                WHERE id = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssssssi", $name, $description, $category, $price, $health_benefits, $certifications, $id);

        return $stmt->execute();  // Return true if successful, false otherwise
    }

    public function deleteProduct($id)
    {
        $sql = "DELETE FROM products WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    public function getProductUpvotes($product_id)
    {
        $sql = "SELECT COUNT(*) as upvotes FROM votes WHERE product_id = ? and vote = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc()['upvotes'];
    }
    public function getProductDownvotes($product_id)
    {
        $sql = "SELECT COUNT(*) as downvotes FROM votes WHERE product_id = ? and vote = 0";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc()['downvotes'];
    }

    public function getVotes($product_id)
    {
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT vote FROM votes WHERE resident_id = ? AND product_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc()['votes'] ?? -1;
    }

    public function castVote($user_id, $product_id, $vote)
    {

        $sql = "INSERT INTO votes (resident_id, product_id, vote) VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE vote = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("iiii", $user_id, $product_id, $vote, $vote);

        return $stmt->execute();
    }
}

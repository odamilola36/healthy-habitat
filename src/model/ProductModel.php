<?php

class ProductModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllProducts($keys, $values)
    {
        $allowedKeys = [
            'name' => 'name',
            'price' => 'price',
        ];

        $sql = "SELECT p.*, COUNT(v.vote) AS positive_votes 
            FROM products p 
            LEFT JOIN votes v ON p.id = v.product_id AND v.vote = 1
            LEFT JOIN product_category pc ON p.prod_cat_id = pc.id";
        $params = [];
        $types = '';

        $whereClause = [];

        for ($i = 0; $i < count($keys); $i++) {
            $key = $keys[$i];
            $value = $values[$i];

            if (array_key_exists($key, $allowedKeys)) {
                $dbColumn = $allowedKeys[$key];
                $type = 's';

                if (in_array($key, ['price', 'quantity'])) {
                    if (!is_numeric($value)) {
                        throw new InvalidArgumentException("Invalid numeric input for $key");
                    }
                    $type = is_float($value + 0) ? 'd' : 'i';
                }

                $operator = '=';
                if ($key === 'name' || $key === 'category') {
                    $operator = 'LIKE';
                }
                if ($key === 'price') {
                    $operator = '<=';
                }

                if ($key !== 'name') {
                    $whereClause[] = "$dbColumn $operator ?";
                    $params[] = $value;
                    $types .= $type;
                } else {
                    $whereClause[] = "LOWER(pc.$dbColumn) $operator LOWER(?)";
                    $params[] = "%$value%";
                    $types .= $type;
                }
            }
        }

        if (!empty($whereClause)) {
            $sql .= " WHERE " . implode(" AND ", $whereClause);
        }

        $sql .= " GROUP BY p.id ORDER BY positive_votes DESC";

        error_log("" . $sql);
        $stmt = $this->db->prepare($sql);

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : [];
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

    public function getProductByName($name)
    {
        $sql = "SELECT COUNT(*) FROM products WHERE name = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        return $count > 0;
    }

    public function getAProductByName($name)
    {
        $sql = "SELECT * FROM products WHERE name = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
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

    public function updateProduct($id, $name, $description, $category, $price, $health_benefits, $certifications, $type, $quantity, $image_name, $prod_cat_id)
    {
        $sql = "UPDATE products 
                SET name = ?, description = ?, pricing_category = ?, price = ?, health_benefits = ?, certifications = ?, product_type = ?, quantity = ?, image_name = ?, prod_cat_id = ?
                WHERE id = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sssssssssii", $name, $description, $category, $price, $health_benefits, $certifications, $type, $quantity, $image_name, $prod_cat_id, $id);

        return $stmt->execute();
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

    public function getAllProductsByBusinessIds($ids)
    {
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $types = str_repeat('i', count($ids));

        $stmt = $this->db->prepare(
            "SELECT products.*, 
            SUM(CASE WHEN votes.vote = TRUE THEN 1 ELSE 0 END) AS true_votes,
            SUM(CASE WHEN votes.vote = FALSE THEN 1 ELSE 0 END) AS false_votes
            FROM products
            LEFT JOIN votes ON products.id = votes.product_id
            WHERE products.business_id IN ($placeholders)
            GROUP BY products.id"
        );
        // "SELECT * FROM products JOIN votes ON products.id = votes.product_id WHERE products.business_id IN ($placeholders) GROUP BY votes.vote HAVING ");
        $stmt->bind_param($types, ...$ids);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getCategoryByName($name)
    {
        $stmt = $this->db->prepare("SELECT * FROM product_category WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function createCategory($name)
    {
        $stmt = $this->db->prepare("INSERT INTO product_category (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function getProductAndCategoryById($id)
    {
        $sql = "SELECT products.*, product_category.name as product_name FROM products JOIN product_category ON products.prod_cat_id = product_category.id WHERE products.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }
}

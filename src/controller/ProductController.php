<?php

class ProductController {

    private $productModel;

    public function __construct() {
        $this->productModel = new ProductModel();
    }
    public function showHome() {
        $products = $this->productModel->getAllProducts();

        include __DIR__ . '/../view/index.php';
    }

    public function showProduct($id) {
        $product = $this->productModel->getProductById($id);

        include __DIR__ . '/../view/product-details.php';
    }

    public function showResidents() {
        $products = $this->productModel->getAllProducts();

        include __DIR__ . '/../view/resident.php';
    }
    
    public function createProduct($name, $description, $category, $price, $health_benefits, $certifications, $business_id) {
        $result =$this->productModel->createProduct($name, $description, $category, $price, $health_benefits, $certifications, $business_id);
        
        if ($result) {
            header('Location: /products');
            exit;
        } else {
            echo "Error creating product.";
        }
    }

}

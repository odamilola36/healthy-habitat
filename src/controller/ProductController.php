<?php

class ProductController
{

    private $productModel;
    private $businessModel;
    private $residentModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->businessModel = new BusinessModel();
        $this->residentModel = new ResidentModel();
    }
    public function showHome()
    {
        $products = $this->productModel->getAllProducts();

        include __DIR__ . '/../view/index.php';
    }

    public function showProduct($id)
    {
        $product = $this->productModel->getProductById($id);
        $business = $this->businessModel->getBusinessById($product['business_id']);
        $upvotes = $this->productModel->getProductUpvotes($id);
        $downvotes = $this->productModel->getProductDownvotes($id);
        $userVote = $this->productModel->getVotes($id);

        if (!$upvotes) {
            $upvotes = 0;
        }
        if (!$downvotes) {
            $downvotes = 0;
        }

        include __DIR__ . '/../view/product-details.php';
    }

    public function vote($postData)
    {
        $user = $this->residentModel->getResidentByUserId($_SESSION['user_id']);
        $productId = $postData['product_id'];
        $vote = $postData['vote'];
        $returnTo = $postData['returnTo'];

        if (!$user) {
            $_SESSION['returnTo'] = $returnTo;
            header('Location: /login.php');
            exit;
        }
        $this->productModel->castVote($user['id'], $productId, $vote);

        header('Location: ' . $returnTo);
    }

    public function showResidents()
    {
        $products = $this->productModel->getAllProducts();

        include __DIR__ . '/../view/resident.php';
    }

    public function showAddProductForm()
    {
        $categories = $this->productModel->getAllCategories();
        include __DIR__ . '/../view/add-product.php';
    }

    public function createProductE($postData)
    {
        $name = $postData['name'];
        $description = $postData['description'];
        $category = $postData['category'];
        $price = $postData['price'];
        $quantity = $postData['quantity'];
        $type = $postData['type'];
        $health_benefits = $postData['benefit'];
        $pricing_category = $postData['pricing_category'];
        $certifications = $postData['certification'];
        $image_name = null;

        if (isset($_SESSION['user_id'])) {
            $business = $this->businessModel->getBusinessByUserId($_SESSION['user_id']);
            if ($business) {
                $business_id = $business['id'];

                $this->productModel->createProduct($name, $description, $pricing_category, $price, $health_benefits, $certifications, $type, $quantity, $image_name, $business_id, $category);
                $_FILES['image']['name'] = $business_id . '_' . $_FILES['image']['name'];
                header('Location: /businesses.php');
                exit;
            } else {
                header('Location: /login.php');
                exit;
            }
        } else {
            header('Location: /login.php');
            exit;
        }
    }

    public function createProduct($postData)
    {
        $name = $postData['name'];
        $description = $postData['description'];
        $category = $postData['category'];
        $price = $postData['price'];
        $quantity = $postData['quantity'];
        $type = $postData['type'];
        $health_benefits = $postData['benefit'];
        $pricing_category = $postData['pricing_category'];
        $certifications = $postData['certification'];
        $image_name = null; // default

        if (isset($_SESSION['user_id'])) {
            $business = $this->businessModel->getBusinessByUserId($_SESSION['user_id']);
            if ($business) {
                $business_id = $business['id'];

                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $imageTmpPath = $_FILES['image']['tmp_name'];
                    $originalName = basename($_FILES['image']['name']);
                    $imageType = mime_content_type($imageTmpPath);
                    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];

                    if (in_array($imageType, $allowedTypes)) {
                        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
                        $image_name = $business_id . '_' . uniqid('img_', true) . '.' . $extension;
                        $destination = __DIR__ . '/../../public/images/' . $image_name;

                        if (!move_uploaded_file($imageTmpPath, $destination)) {
                            echo "Failed to upload image.";
                            exit;
                        }
                    } else {
                        echo "Only JPEG, PNG, JPG, or WEBP images are allowed.";
                        exit;
                    }
                }

                $this->productModel->createProduct(
                    $name,
                    $description,
                    $pricing_category,
                    $price,
                    $health_benefits,
                    $certifications,
                    $type,
                    $quantity,
                    $image_name,
                    $business_id,
                    $category
                );

                header('Location: /businesses.php');
                exit;
            } else {
                header('Location: /login.php');
                exit;
            }
        } else {
            header('Location: /login.php');
            exit;
        }
    }

    public function showBusinessHome()
    {
        $userId = $_SESSION['user_id'];
        $business = $this->businessModel->getBusinessByUserId($userId);
        $products = $this->productModel->getAllProductsForBusiness($business['id']);

        file_put_contents('debug.log', data: print_r($products, true));


        include __DIR__ . '/../view/businesses.php';
    }

}

<?php

class ProductController
{

    private $productModel;
    private $businessModel;
    private $residentModel;
    private $councilModel;
    private $areaModel;
    private $businessAreaModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->businessModel = new BusinessModel();
        $this->residentModel = new ResidentModel();
        $this->councilModel = new CouncilModel();
        $this->areaModel = new AreaModel();
        $this->businessAreaModel = new BusinessAreaModel();
    }
    public function showHome($key, $value)
    {
        $products = $this->productModel->getAllProducts($key, $value);

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

    public function showResidentHome($key, $value)
    {
        $areaId = $this->residentModel->getResidentByUserId($_SESSION['user_id'])['area_id'];
        $businessAreas = $this->businessAreaModel->getBusinessIdsByArea($areaId);
        $products = $this->productModel->getAllProductsForBusinesses($key, $value, $businessAreas);

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

        if ($this->getProductByName($name)) {
            $addprod_error = "Product with this name already exists.";
            header('Location: /add-product.php');
            exit;
        }

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

                header('Location: /business-page.php');
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

    private function getProductByName($name)
    {
        return $this->productModel->getProductByName($name);
    }

    public function showBusinessHome($key, $value)
    {
        $userId = $_SESSION['user_id'];
        $business = $this->businessModel->getBusinessByUserId($userId);
        $products = $this->productModel->getAllProductsForBusiness($key, $value, $business['id']);


        include __DIR__ . '/../view/business-page.php';
    }

    public function showCouncilPageHome($key, $value)
    {
        $userId = $_SESSION['user_id'];
        $council = $this->councilModel->getCouncilByUserId($userId);
        $areas = $this->areaModel->getAreasByCouncilId($council['id']);
        $areaIds = array_map(fn($obj) => $obj['id'], $areas);
        $businessAreas = $this->businessAreaModel->getBusinessAreaByAreaIds($areaIds);
        $businessIds = array_map(fn($obj) => $obj['business_id'], $businessAreas);
        $products = $this->productModel->getAllProductsForBusinesses($key, $value, $businessIds);


        include __DIR__ . '/../view/council-page.php';
    }

    public function showAddAreaForm()
    {
        include __DIR__ . '/../view/add-area.php';
    }

    public function createArea($postData)
    {
        $name = $postData['name'];
        $county = $postData['county'];
        $country = $postData['country'];

        if (isset($_SESSION['user_id'])) {
            $council = $this->councilModel->getCouncilByUserId($_SESSION['user_id']);
            if ($council) {
                $area = $this->areaModel->getAreaByNameCounty($name, $county);
                if ($area) {
                    $_SESSION['error'] = 'Area already exists!';
                    header('Location: /add-area.php');
                    exit;
                }

                $councilId = $council['id'];
                $this->areaModel->createArea(
                    $councilId,
                    $name,
                    $county,
                    $country
                );
                $_SESSION['success'] = 'Area added successfully!';
                header('Location: /add-area.php');
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

    public function showAreas()
    {
        $userId = $_SESSION['user_id'];
        $council = $this->councilModel->getCouncilByUserId($userId);
        $areas = $this->areaModel->getAreasByCouncilId($council['id']);

        include __DIR__ . '/../view/areas.php';
    }

    public function showBusinesses()
    {
        $userId = $_SESSION['user_id'];
        $council = $this->councilModel->getCouncilByUserId($userId);
        $areas = $this->areaModel->getAreasByCouncilId($council['id']);
        $areaIds = array_map(fn($obj) => $obj['id'], $areas);
        $businessAreas = $this->businessAreaModel->getBusinessAreaByAreaIds($areaIds);
        $businessIds = array_map(fn($obj) => $obj['business_id'], $businessAreas);
        $businesses = $this->businessModel->getBusinessAndUsersByIds($businessIds);

        include __DIR__ . '/../view/businesses.php';
    }

    public function showAddCategoryForm()
    {
        include __DIR__ . '/../view/add-category.php';
    }

    public function createCategory($postData)
    {
        $name = $postData['name'];

        if (isset($_SESSION['user_id'])) {
            $council = $this->councilModel->getCouncilByUserId($_SESSION['user_id']);
            if ($council) {
                $category = $this->productModel->getCategoryByName($name);
                if ($category) {
                    $_SESSION['error'] = 'Category already exists!';
                    header('Location: /add-category.php');
                    exit;
                }

                $councilId = $council['id'];
                $this->productModel->createCategory($name);
                $_SESSION['success'] = 'Category added successfully!';
                header('Location: /add-category.php');
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

    public function showCategories()
    {
        $categories = $this->productModel->getAllCategories();

        include __DIR__ . '/../view/categories.php';
    }

    public function showEditProductForm($id)
    {
        $product = $this->productModel->getProductAndCategoryById($id);
        $categories = $this->productModel->getAllCategories();

        include __DIR__ . '/../view/edit-product.php';
    }

    public function editProduct($id, $postData)
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

        $product = $this->productModel->getAProductByName($name);
        if ($product && $product['id'] != $id) {
            $_SESSION['error'] = "Product with this name already exists.";
            header('Location: /edit-product/' . urlencode($id));
            exit;
        }

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
                            $_SESSION['error'] = "Failed to upload image.";
                            header('Location: /edit-product/' . urlencode($id));
                            exit;
                        }
                    } else {
                        $_SESSION['error'] = "Only JPEG, PNG, JPG, or WEBP images are allowed.";
                        header('Location: /edit-product/' . urlencode($id));
                        exit;
                    }
                } else {
                    $image_name = $product['image_name'];
                }

                $this->productModel->updateProduct(
                    $id,
                    $name,
                    $description,
                    $pricing_category,
                    $price,
                    $health_benefits,
                    $certifications,
                    $type,
                    $quantity,
                    $image_name,
                    $category
                );

                header('Location: /business-page.php');
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
}

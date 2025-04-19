<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-success sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Healthy Habitat Network</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="resident.php">Home</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <?php
            if (!empty($products)) {
                echo '<h2>Health & Wellness Products</h2>';
                $count = 0;
                foreach ($products as $index => $product) {
                    if ($count % 3 === 0) {
                        echo '<div class="row">';
                    }
                        echo '<div class="col-md-4">';    
                            echo '<div class="card">';
                                echo '<img src="images/product1.jpg" class="card-img-top" alt="Product">';
                                echo '<div class="card-body">';
                                    echo '<h5 class="card-title">' . $product['name'] . '</h5>';
                                    echo '<p class="card-text">' . $product['description'] . '</p>';
                                    echo '<p><strong>Price: </strong>' . $product['price'] . '</p>';
                                    echo '<a href="product-details.php?id='. urlencode($product['id']) . '" class="btn btn-success btn-sm">View More...</a>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    
                        $count++;

                    if ($count % 3 === 0 || $index === array_key_last($products)) {
                        echo '</div>'; 
                    }
                }
            } else {
                echo "No products found";
            }
        ?>
    </div>
<?php include("../src/include/footer.php");?>
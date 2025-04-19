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
            <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button> -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Home</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <?php
            if (!empty($product)) {
                echo '<div class="row">';
                    echo '<div class="col-md-6">'; 
                        echo '<img src="images/product1.jpg" class="img-fluid" alt="Product">';
                    echo '</div>';
                    echo '<div class="col-md-6">';
                        echo '<h2>' . $product['name'] . '</h2>';
                        echo '<p>' . $product['description'] . '</p>';
                        echo '<p><strong>Price: </strong>' . $product['price'] . '</p>';
                        echo '<p><strong>Health Benefits: </strong>' . $product['health_benefits'] . '</p>';
                        echo '<p><strong>Category: </strong>' . $product['pricing_category'] . '</p>';
                        echo '<button class="btn btn-success me-3">Vote Yes</button>';
                        echo '<button class="btn btn-danger">Vote No</button>';            
                    echo '</div>';
                echo '</div>';
            } else {
                echo "No products found";
            }
        ?>
    </div>

<?php include("../src/include/footer.php");?>

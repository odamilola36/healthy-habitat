<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
    <link rel="stylesheet" href="../../style/styles.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-success sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Healthy Habitat Network</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="council.php">Home</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
    <div class="sidebar">
      <h3>Menu</h3>
      <ul>
        <li onclick="showContent('home')">Home</li>
        <li onclick="showContent('profile')">Profile</li>
        <li onclick="showContent('upload')">Upload Image</li>
        <li onclick="showContent('settings')">Settings</li>
      </ul>
    </div>

    <div class="content" id="contentArea">
      <h2>Welcome!</h2>
      <p>Select an item from the menu.</p>
    </div>
  </div>

<?php include("../src/include/footer.php");?>
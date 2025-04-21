<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles.css" rel="stylesheet">
    <link rel="stylesheet" href="../../style/styles.css"> -->
</head>
<body class="flex flex-col min-h-screen font-sans">
    <nav class="bg-emerald-600 text-white sticky top-0 z-50">
        <div class="max-w-screen-xl mx-auto px-4 py-4 flex justify-between items-center">
            <a class="text-xl font-bold" href="#">Healthy Habitat Network</a>
            <ul class="flex space-x-6">
                <li>
                <a href="#" class="hover:text-gray-300 font-medium">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="flex flex-1 min-h-0">
        <div class="w-64 text-gray p-6 fixed h-full">
            <ul class="space-y-4">
                <li class="cursor-pointer">
                    <a href="business-page.php" class="hover:text-emerald-600 font-medium">Home</a>
                </li>
                <li class="cursor-pointer">
                    <a href="add-product.php" class="hover:text-emerald-600 font-medium">Add Product</a>
                </li>
            </ul>
        </div>

        <div class="ml-64 flex-1 overflow-y-auto p-8 bg-gray-100" id="contentArea">
            <h2 class="text-3xl font-semibold mb-4">Welcome!</h2>
            <p class="text-gray-700">Select an item from the menu.</p>
        </div>
    </div>

<?php include("../src/include/footer.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                    <a href="council-page.php" class="hover:text-emerald-600 font-medium">Home</a>
                </li>
                <li class="cursor-pointer">
                    <a href="businesses.php" class="hover:text-emerald-600 font-medium">Buisness</a>
                </li>
                <li class="cursor-pointer">
                    <a href="areas.php" class="hover:text-emerald-600 font-medium">Areas</a>
                </li>
                <li class="cursor-pointer">
                    <a href="add-area.php" class="hover:text-emerald-600 font-medium">Add Areas</a>
                </li>
            </ul>
        </div>

        <div class="ml-64 flex-1 overflow-y-auto p-8 bg-gray-100">
            <h2 class="text-3xl font-semibold mb-4">Welcome!</h2>
            <p class="text-gray-700">Select an item from the menu.</p>
        </div>
    </div>

<?php include("../src/include/footer.php");?>
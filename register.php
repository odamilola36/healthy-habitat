<?php
$currentYear = date('Y');
?>
<?php error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<?php
$formSuccess = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $user_type = $_POST['user_type'];

    if ($password !== $cpassword) {
        $formSuccess = true;
        echo "Password does not match.";
    }
    // if (!empty($name) && !empty($email) && !empty($email)) {
    //     $formSuccess = true;
    // }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    <link rel="stylesheet" href="style/login-register.css">
</head>

<body>
    <div class="r-container">
        <div class="left-container">
            <form action="#" method="POST">
                <h2>Register</h2>
                <label for="name">First Name:</label>
                <input type="text" id="name" name="fname" required><br><br>

                <label for="name">Last Name:</label>
                <input type="text" id="name" name="lname" required><br><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br><br>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br><br>

                <label for="password">Confirm Password:</label>
                <input type="password" id="password" name="cpassword" required><br><br>

                <label for="user_type">Select Role:</label>
                <select id="user_type" name="user_type" required>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>

                <button type="submit" class="btn" name="submit">Register</button>
                <!-- <input type="submit" value="Register"> -->
            </form>
            <span> Already have an account? <a href="login.php" class="btn">Login</a> </span>
        </div>
        <?php include("include/sidebar.php"); ?>
    </div>
    <div id="myModal" class="modal" style="<?php echo $formSuccess ? 'display:block;' : 'display:none;'; ?>">
        <div class="modal-content">
            <span class="close" onclick="closeModalAndRedirect()">&times;</span>
            <h2>
                <?php
                if ($formSuccess) {
                    echo "Account created successfully!";
                } else {
                    echo "Password does not match.";
                }
                ?>
            </h2>
        </div>
    </div>
    <script src="script.js"></script>

    <?php include("include/footer.php"); ?>


    <?php
    if (!empty($products)) {
        $count = 0;
        foreach ($products as $index => $product) {
            $imagePath = !empty($product['image']) ? 'images/' . htmlspecialchars($product['image']) : 'images/default.jpg';
            if ($count % 3 === 0) {
                echo '<div class="flex flex-row flex-wrap gap-4 py-2">';
            }
            ?>

            <div class="bg-white border border-gray-200 rounded-lg shadow-sm w-full sm:w-1/2 md:w-1/3 lg:w-1/4">
                <a href="product-details/<?= urlencode($product['id']) ?>">
                    <img class="rounded-t-lg w-auto" src="../../<?= $imagePath ?>" alt="Product" />
                </a>
                <div class="p-5">
                    <a href="product-details/<?= urlencode($product['id']) ?>">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                            <?= htmlspecialchars($product['name']) ?>
                        </h5>
                    </a>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                        <?= htmlspecialchars($product['description']) ?>
                    </p>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400"><strong>Price:</strong>£
                        <?= htmlspecialchars($product['price']) ?>
                    </p>
                    <a href="product-details/<?= urlencode($product['id']) ?>"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-yellow-400 rounded-lg">
                        View more
                        <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                    </a>
                </div>
            </div>

            <?php
            $count++;

            // Close the row after every 3 products or if it's the last product
            if ($count % 3 === 0 || $index === array_key_last($products)) {
                echo '</div>';
            }
        }
    } else {
        echo "No products found";
    }
    ?>
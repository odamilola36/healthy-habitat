<?php
    $currentYear = date('Y');
?>
<?php error_reporting(E_ALL);
    ini_set('display_errors', 1);
?>
<?php
    $formSuccess = false;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];

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
        <?php include("include/sidebar.php");?>
        <div class="left-container">
            <form action="#" method="POST">
                <h2>Forgot Password</h2>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br><br>

                <label for="password">New Password:</label>
                <input type="password" id="password" name="password" required><br><br>

                <label for="password">Confirm Password:</label>
                <input type="password" id="password" name="password" required><br><br>

                <button type="submit" class= "btn" name="submit">Login</button>
            </form>
            <!-- <a href="forgot_password.php">Forgot Password</a>
            <span> Don't have an account <a href="register.php" class="btn">Register</a> </span> -->
        </div>
    </div>
    <script src="script.js"></script>

<?php include("include/footer.php");?>


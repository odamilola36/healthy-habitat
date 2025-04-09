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
                </select><br><br>

                <button type="submit" class= "btn" name="submit">Register</button>
                <!-- <input type="submit" value="Register"> -->
            </form>
            <span> Already have an account? <a href="login.php" class="btn">Login</a> </span>
        </div>
        <?php include("include/sidebar.php");?>
    </div>
    <div id="myModal" class="modal" style="<?php echo $formSuccess ? 'display:block;' : 'display:none;'; ?>">
        <div class="modal-content">
            <span class="close" onclick= "closeModalAndRedirect()">&times;</span>
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

<?php include("include/footer.php");?>

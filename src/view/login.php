<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="r-container">
        <div class="left-container">
            <form action="login.php" method="POST">
                <h2>Login</h2>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <label for="remember-me">
                    <input type="checkbox" id="remember-me" name="remember-me">
                    Remember Me
                </label>
                <select id="user_type" name="user_type" required>
                    <option value="resident">Resident</option>
                    <option value="business">Business</option>
                    <option value="council">Council</option>
                </select>
                <button type="submit" class= "btn" name="submit">Login</button>
            </form>
            <a class="l-page" href="forgot_password.php">Forgot Password</a>
            <span> Don't have an account? <a href="register.php" class="btn">Register</a> </span>
        </div>
    </div>
</body>
</html>
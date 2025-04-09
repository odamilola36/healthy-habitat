    <?php error_reporting(E_ALL);
        ini_set('display_errors', 1);
    ?>
    <?php include("include/header.php");?> 

    <?php
        $formSuccess = false;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $message = $_POST['message'];

            if (!empty($name) && !empty($email) && !empty($email)) {
                $formSuccess = true;
            }
        } 
    ?>

    <section class="intro">
        <div class="container">
            <h2>Welcome to the Healthy Habitat Network</h2>
            <p>Our mission is to connect communities, organizations, and individuals in the fight to protect our planet's ecosystems. We believe in the power of collaboration to create healthier habitats for all living beings.</p>
            <div class=btn-container>
                <a href="register.php" class="btn">Register</a>
                <a href="login.php" class="btn">Login</a>
            </div>
        </div>
    </section>

    <section class="features">
        <div class="container">
            <h2>Our Goals</h2>
            <ul>
                <li>Promote environmental awareness</li>
                <li>Support sustainable practices</li>
                <li>Protect wildlife habitats</li>
                <li>Encourage community action</li>
            </ul>
        </div>
    </section>

    <section class="contact" id="contact">
        <div class="container">
            <h2>Contact Us</h2>
            <form method="POST" action="#">
                <label for="name">Your Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Your Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="message">Your Message:</label>
                <textarea id="message" name="message" required></textarea>

                <button type="submit">Submit</button>
            </form>
        </div>
    </section>
    
    <div id="myModal" class="modal" style="<?php echo $formSuccess ? 'display:block;' : 'display:none;'; ?>">
        <div class="modal-content">
            <span class="close" onclick= "closeModalAndRedirect()">&times;</span>
            <h2>
                <?php
                    if ($formSuccess) {
                        echo "Form submitted successfully!";
                    }
                ?>
            </h2>
        </div>
    </div>
    <script src="script.js"></script>

<?php include("include/footer.php");?>

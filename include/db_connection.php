<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "healthy_habitat_network";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";

?>

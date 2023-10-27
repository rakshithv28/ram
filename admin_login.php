<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Database connection
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "employees";

    // Create connection
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Validate user credentials against admin_login table
    $sql = "SELECT * FROM admin_login WHERE userid='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Redirect to index.html upon successful login
        header("Location: index.html");
        exit();
    } else {
        // If login fails, redirect back to the login page
        echo "<script>alert('Incorrect username or password. Please try again.');</script>";
        exit();
    }

    // Close connection
   
}
?>
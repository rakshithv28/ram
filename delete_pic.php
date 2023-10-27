<?php
session_start();

// Check if the user is logged in, and if not, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "employees";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// Get the current profile image path from the database
$sql = "SELECT profile_image FROM employee_info WHERE id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $profile_image_path = $row['profile_image'];

    // Delete the profile picture file from the server
    if (!empty($profile_image_path) && $profile_image_path !== "default_profile.jpg") {
        unlink($profile_image_path);
    }

    // Update the 'profile_image' column in the database to NULL
    $update_sql = "UPDATE employee_info SET profile_image = NULL WHERE id = $user_id";
    if ($conn->query($update_sql) === TRUE) {
        // Redirect back to the user profile page after deletion
        header("Location: profile.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>

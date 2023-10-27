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

// Retrieve the user's profile information
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM employee_info WHERE id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $user_name = $row['name'];
    $user_title = $row['title'];
    $user_email = $row['email'];
    $user_phone = $row['phone'];
    $user_password = $row['password'];
    $profile_image = $row['profile_image']; // Get the profile picture path
} else {
    $user_name = "Name not found";
    $user_title = "Title not found";
    $user_email = "Email not found";
    $user_phone = "Phone not found";
    $user_password = "Password not found";
    $profile_image = "default_profile.jpg"; // Set a default image path
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/ffc92e568f.js" crossorigin="anonymous"></script>
    <title>User Profile</title>
    <!-- Include your CSS stylesheets here -->
    
    <!-- Add any additional styling if needed -->
</head>
<body>
   <a href="indexuser.html" class="bzx"><i class="fa-solid fa-house fa-2xl"></i></a>
    <div class="container">
        <h1>User Profile</h1>
        <?php
        // Display the user's profile information
        echo "<p><strong>Profile Picture:</strong></p>";
        if (empty($profile_image)) {
            echo "No profile picture found. <a href='upload_profile_pic.php'>Upload Profile Picture</a>";
        } else {
            echo "<img src='$profile_image' alt='Profile Picture' width='150'>";
            echo "<br><a href='upload_profile_pic.php'>Change Profile Picture</a>"; // Provide an option to change the profile picture
            echo "<br><a href='delete_pic.php'>Delete Profile Picture</a>"; // Add a link to delete the profile picture
        }
        echo "<p><strong>Name:</strong> $user_name</p>";
        echo "<p><strong>Title:</strong> $user_title</p>";
        echo "<p><strong>Email:</strong> $user_email</p>";
        echo "<p><strong>Phone:</strong> $user_phone</p>";
        echo "<p><strong>Password:</strong> $user_password</p>";
        
        // Display or offer the option to upload the profile picture
        
        ?>
    </div>
</body>
<link rel="stylesheet" href="./styles/profile.css">
</html>

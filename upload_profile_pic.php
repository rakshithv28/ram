<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle profile picture upload
    $user_id = $_SESSION['user_id'];

    // Check for file upload errors and save the file with a unique name
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'profile_pics/';
        $file_extension = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
        $new_filename = "profile_$user_id.$file_extension";
        $target_path = $upload_dir . $new_filename;

        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_path)) {
            // Update the 'profile_image' column in the database
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "employees";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "UPDATE employee_info SET profile_image = '$target_path' WHERE id = $user_id";
            $conn->query($sql);

            $conn->close();
        }
    }
    header("Location:profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Profile Picture</title>
</head>
<body>
    <div class="container">
        <h1>Upload Profile Picture</h1>
       
        <!-- Inside your form where users upload their profile picture -->
        <form action="upload_profile_pic.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="profile_picture">
            <button type="submit">Upload</button>
           <a href="profile.php" class="cancel-button">Cancel</a> <!-- Add a Cancel button -->
    </form>

    </div>
</body>
<link rel="stylesheet" href="upload.css">
</html>

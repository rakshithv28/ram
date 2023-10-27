<?php
// Start the session (this should be placed at the top of your PHP file)
session_start();

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";
    $confirmPassword = isset($_POST["confirm_password"]) ? $_POST["confirm_password"] : "";

    // Perform some basic validation
    if (empty($email) || empty($password) || empty($confirmPassword)) {
        // Handle validation errors, e.g., display an error message
        echo "Please fill in all fields.";
    } elseif ($password !== $confirmPassword) {
        // Handle password mismatch
        echo "Passwords do not match.";
    } else {
        // Connect to your database
        $conn = new mysqli('localhost', 'root', '', 'employees');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if the email already exists in the database
        $checkEmailQuery = "SELECT email FROM user WHERE email = ?";
        $checkEmailStmt = $conn->prepare($checkEmailQuery);
        $checkEmailStmt->bind_param("s", $email);
        $checkEmailStmt->execute();
        $checkEmailStmt->store_result();

        if ($checkEmailStmt->num_rows > 0) {
            // Email already exists, show a popup message
            echo "User with this email already exists. Please log in.";

            // Redirect to the login page after a brief delay
            header("refresh:2;url=user_login.html"); // Redirect after 2 seconds
            exit(); // Stop further execution of the script
        } else {
            // Email doesn't exist, proceed with user registration
            // Define the SQL query to insert data, excluding the "id" column
            $insertQuery = "INSERT INTO user (email, password) VALUES (?, ?)";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bind_param("ss", $email, $password); // Inserting plaintext password

            if ($insertStmt->execute()) {
                echo "User added successfully.";
                header("refresh:2;url=indexuser.html");
            } else {
                echo "Error adding user: " . $insertStmt->error;
            }
        }

        // Close the database connection
        $conn->close();
    }
}
?>

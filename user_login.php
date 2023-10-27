<?php
session_start();

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Query the database to check if an employee with the provided email and password exists
    $sql = "SELECT id, email, password, name, title, phone FROM employee_info WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $_SESSION["user_id"] = $row["id"];
        $_SESSION["user_name"] = $row["name"];
        $_SESSION["user_title"] = $row["title"];
        $_SESSION["user_email"] = $row["email"];
        $_SESSION["user_phone"] = $row["phone"];
        // Redirect to the employee information page or wherever you want
        header("Location: indexuser.html");
        exit(); // Important to exit script after redirection
    } else {
        // Incorrect email or password
        echo '<script>alert("Incorrect email or password. Please try again.");';
        echo 'window.location.href = "user_login12.php";</script>';
    }
}

// Close the database connection
$conn->close();
?>

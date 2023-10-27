<?php
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

// Get data from the registration form
$name = $_POST['name'];
$employee_id = $_POST['employee-id'];
$title = $_POST['title'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$aadhar_no = $_POST['aadhar-no'];
$password = $_POST['password'];

// Check for duplicate entry
$duplicate_check_sql = "SELECT employee_id FROM employee_info WHERE employee_id = '$employee_id'";
$duplicate_check_result = $conn->query($duplicate_check_sql);

if ($duplicate_check_result->num_rows > 0) {
    echo '<script>alert("Duplicate entry! Employee ID already exists.");</script>';
} else {
    // Insert data into the database
    $insert_sql = "INSERT INTO employee_info (name, employee_id, title, email, phone, aadhar_number, password) VALUES ('$name', '$employee_id', '$title', '$email', '$phone', '$aadhar_no', '$password')";

    if ($conn->query($insert_sql) === TRUE) {
        // Data inserted successfully, you can redirect to the employee information page
        header("Location: user_login12.php");
        exit();
    } else {
        echo "Error: " . $insert_sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

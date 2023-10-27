<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "employees";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the updated employee information from the form
    $id = $_POST["id"];
    $name = $_POST["name"];
    $employee_id = $_POST["employee_id"];
    $title = $_POST["title"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $aadhar_number = $_POST["aadhar_number"];

    // Update the employee information in the database
    $sql = "UPDATE employee_info SET name='$name', employee_id='$employee_id', title='$title', email='$email', phone='$phone', aadhar_number='$aadhar_number' WHERE id=$id";

    $success = false;

    if ($conn->query($sql) === TRUE) {
        $success = true;
    }

    echo json_encode(["success" => $success]);
}

// Close the database connection
$conn->close();
?>

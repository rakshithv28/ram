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

if(isset($_POST['id'])) {
    $employeeId = $_POST['id'];

    // Fetch data from the database based on the received ID
    $sql = "SELECT * FROM employee_info WHERE id = $employeeId";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Fetch employee data as an associative array
        $row = $result->fetch_assoc();

        // Return employee data as JSON response
        echo json_encode($row);
    } else {
        // Return an empty JSON object if no data is found
        echo json_encode((object)[]);
    }
} else {
    // Return an empty JSON object if no ID is provided
    echo json_encode((object)[]);
}

// Close connection
$conn->close();
?>

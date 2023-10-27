<?php
// Include PhpSpreadsheet
require './vendor/autoload.php';

// Database configuration
$host = "localhost";
$username = "root";
$password = "";
$database = "employees";

// Connect to the database
$mysqli = new mysqli($host, $username, $password, $database);

if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

// Handle the Excel file upload
$uploadSuccess = false; // Track upload success
$errorMessage = "";

if ($_FILES['excel_file']['error'] == 0) {
    $file = $_FILES['excel_file']['tmp_name'];

    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
    $worksheet = $spreadsheet->getActiveSheet();

    foreach ($worksheet->getRowIterator() as $row) {
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(false);

        $data = [];
        foreach ($cellIterator as $cell) {
            $data[] = $cell->getValue();
        }

        // Process and insert data into the database
        $name = $data[0]; // Adjust indices based on your Excel file structure
        $employeeId = $data[1];
        $title = $data[2];
        $email = $data[3];
        $phone = $data[4];
        $aadhar = $data[5];
        $password=$data[6];

        // Insert data into the database using prepared statements
        $query = "INSERT INTO employee_info (name, employee_id, title, email, phone, aadhar_number,password) VALUES (?, ?, ?, ?, ?, ?,?)";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('sssssss', $name, $employeeId, $title, $email, $phone, $aadhar,$password);

        try {
            $stmt->execute();
            $uploadSuccess = true; // Set to true if at least one record was successfully inserted
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) { // 1062 is the error code for duplicate entry
                $errorMessage = "Duplicate entry";
            } else {
                $errorMessage = $e->getMessage(); // Handle other database errors
            }
        }
    }
}

// Close the database connection
$mysqli->close();

// Show an alert with an error message and redirect to the same page
if ($uploadSuccess) {
    echo '<script>alert("Upload successful");</script>';
    echo '<script>window.location.href = "index.html";</script>';
} elseif (!empty($errorMessage)) {
    echo "<script>alert('$errorMessage'); window.location.href = 'index.html';</script>";
}

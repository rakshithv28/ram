<?php
session_start(); // Start the session to access session variables

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $employeeName = $_POST["employeeName"];
    $managerName = $_POST["managerName"];
    $teamLeader = $_POST["teamLeader"];
    $leaveType = $_POST["leaveType"];
    $startDate = $_POST["startDate"];
    $endDate = $_POST["endDate"];
    $teamLeaderEmail = $_POST["teamLeader"];

    // Get sender email from session variable (assuming it was stored during login)
    $senderEmail = $_SESSION["user_email"]; // Replace "user_email" with the actual session variable name storing the email

    // Process leave request and other operations here...

    // Send email notification to the team leader
    $to = $teamLeaderEmail;
    $subject = "Leave Request Submission";
    $message = "Hello $teamLeader,\n\n";
    $message .= "A leave request has been submitted by $employeeName under your team.\n";
    $message .= "Leave Type: $leaveType\n";
    $message .= "Start Date: $startDate\n";
    $message .= "End Date: $endDate\n\n";
    $message .= "Please review and take necessary actions.\n\n";
    $message .= "Best regards,\n";
    $message .= "Leave Management System";

    // Send the email
    $headers = "From: $senderEmail"; // Use the sender's email retrieved from the session variable
    mail($to, $subject, $message, $headers);
    
    if(mail($to, $subject, $message, $headers)) {
        echo "Email sent successfully!";
    } else {
        echo "Email failed to send.";
    }
    exit();
    
}
?>

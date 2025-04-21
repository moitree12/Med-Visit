<?php

session_start();
date_default_timezone_set('Asia/Dhaka');


$successMessage = "";


$conn = new mysqli("localhost", "root", "", "medispritus ");


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// When form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = $conn->real_escape_string($_POST["name"]);
    $email = $conn->real_escape_string($_POST["email"]);
    $subject = $conn->real_escape_string($_POST["subject"]);
    $message = $conn->real_escape_string($_POST["message"]);

    $sql = "INSERT INTO messages (name, email, subject, message) 
            VALUES ('$name', '$email', '$subject', '$message')";

    if ($conn->query($sql) === TRUE) {
        $successMessage = "✅ Thank you, $name! Your message has been received.";
    } else {
        $successMessage = "❌ Something went wrong. Please try again.";
    }
}


$conn->close();
?>


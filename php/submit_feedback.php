<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");  // Redirect to login if not logged in
    exit();
}

$user_id = $_SESSION['user_id'];
$feedback_text = $_POST['feedback_text'];

// Database connection
$host = "localhost";
$user = "root";
$password = "";
$dbname = "medispritus";
$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert new feedback into the database
$query = $conn->prepare("INSERT INTO feedback (user_id, feedback_text) VALUES (?, ?)");
$query->bind_param("is", $user_id, $feedback_text);
$query->execute();

if ($query->affected_rows > 0) {
    echo "Feedback submitted successfully!";
    header("Refresh: 2; url=user_feedback.php");  // Redirect to feedback page
} else {
    echo "Error submitting feedback.";
}

$conn->close();
?>

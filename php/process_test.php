<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit;
}


$host = "localhost";
$user = "root";
$password = "";
$dbname = "medispritus";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $test_name = $_POST['test_name'];
    $test_date = $_POST['test_date'];

    $stmt = $conn->prepare("INSERT INTO tests (user_id, test_name, test_date) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $test_name, $test_date);

    if ($stmt->execute()) {
        echo "Test booked successfully! <a href='dashboard.php'>Go back to Dashboard</a>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

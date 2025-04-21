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


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $nurse_name = $_POST['nurse_name'];
    $service_date = $_POST['service_date'];

    $stmt = $conn->prepare("INSERT INTO nurses (user_id, nurse_name, service_date) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $nurse_name, $service_date);

    if ($stmt->execute()) {
        echo "Nurse booked successfully! <a href='dashboard.php'>Go back to Dashboard</a>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>


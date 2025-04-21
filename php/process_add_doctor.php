<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
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
    $name = $_POST['name'];
    $specialty = $_POST['specialty'];
    $availability = $_POST['availability'];

    $stmt = $conn->prepare("INSERT INTO doctors (name, specialty, availability) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $specialty, $availability);

    if ($stmt->execute()) {
        echo "Doctor added successfully! <a href='admin_dashboard.php'>Back to Dashboard</a>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>


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


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION['user_id'];
    $doctor_id = isset($_POST['doctor_id']) ? intval($_POST['doctor_id']) : 0;
    $appointment_date = isset($_POST['appointment_date']) ? trim($_POST['appointment_date']) : '';

    if ($doctor_id > 0 && !empty($appointment_date)) {
        $stmt = $conn->prepare("INSERT INTO appointments (user_id, doctor_id, appointment_date, status) VALUES (?, ?, ?, 'Pending')");
        $stmt->bind_param("iis", $user_id, $doctor_id, $appointment_date);

        if ($stmt->execute()) {
            echo "<p style='color: green;'>✅ Appointment booked successfully!</p>";
            echo "<p><a href='dashboard.php'>Return to Dashboard</a></p>";
        } else {
            echo "<p style='color: red;'>❌ Error booking appointment: " . htmlspecialchars($stmt->error) . "</p>";
        }

        $stmt->close();
    } else {
        echo "<p style='color: red;'>❌ Invalid input. Please fill out all required fields.</p>";
    }
} else {
    echo "<p style='color: red;'>Invalid request method.</p>";
}

$conn->close();
?>

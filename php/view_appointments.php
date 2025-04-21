<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
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

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT appointments.id, doctors.name AS doctor_name, appointments.date, appointments.time, appointments.status
                        FROM appointments
                        JOIN doctors ON appointments.doctor_id = doctors.id
                        WHERE appointments.patient_id = $user_id");
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Appointments</title>
</head>
<body>
    <h1>My Appointments</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Doctor</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['doctor_name'] ?></td>
            <td><?= $row['date'] ?></td>
            <td><?= $row['time'] ?></td>
            <td><?= $row['status'] ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>

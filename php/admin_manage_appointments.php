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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $conn->query("UPDATE appointments SET status='$status' WHERE id=$id");
}

$result = $conn->query("SELECT appointments.id, users.username AS patient_name, doctors.name AS doctor_name, appointments.date, 
appointments.status , appointments.created_at,
                        FROM appointments
                        JOIN users ON appointments.patient_id = users.id
                        JOIN doctors ON appointments.doctor_id = doctors.id");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Appointments</title>
</head>
<body>
    <h1>Manage Appointments</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Patient</th>
            <th>Doctor</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
            <th>Change Status</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['patient_name'] ?></td>
            <td><?= $row['doctor_name'] ?></td>
            <td><?= $row['date'] ?></td>
            <td><?= $row['status'] ?></td>
            <td><?= $row['created_at'] ?></td>
            <td>
                <form method="post">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <select name="status">
                        <option value="Pending">Pending</option>
                        <option value="Confirmed">Confirmed</option>
                        <option value="Completed">Completed</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                    <button type="submit">Update</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>

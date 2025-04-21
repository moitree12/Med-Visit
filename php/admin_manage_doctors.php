<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin_login.html");
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

$message = "";


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_doctor'])) {
    $doctor_id = $_POST['doctor_id'];

    $delete_appointments = $conn->prepare("DELETE FROM appointments WHERE doctor_id = ?");
    $delete_appointments->bind_param("i", $doctor_id);
    if (!$delete_appointments->execute()) {
        $message = "Error deleting appointments: " . $conn->error;
    } else {
        $delete_doctor = $conn->prepare("DELETE FROM doctors WHERE id = ?");
        $delete_doctor->bind_param("i", $doctor_id);
        if ($delete_doctor->execute()) {
            $message = "Doctor removed successfully!";
        } else {
            $message = "Error removing doctor: " . $conn->error;
        }
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $doctor_id = $_POST['doctor_id'];
    $status = $_POST['status'];

    $update_status = $conn->prepare("UPDATE doctors SET status = ? WHERE id = ?");
    $update_status->bind_param("si", $status, $doctor_id);
    if ($update_status->execute()) {
        $message = "Status updated successfully!";
    } else {
        $message = "Error updating status: " . $conn->error;
    }
}


$result = $conn->query("SELECT id, name, specialty, status FROM doctors");
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Manage Doctors</title>
  <link rel="stylesheet" href="../css/style1.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    header {
      background-color: #8dbab9;
      padding: 20px;
      text-align: center;
      color: white;
    }

    .nav-buttons a {
      display: inline-block;
      margin: 0 10px;
      color: #00cec9;
      background-color: white;
      padding: 8px 15px;
      text-decoration: none;
      border-radius: 5px;
      font-weight: bold;
    }

    .nav-buttons a:hover {
      background-color: #019a96;
      color: white;
    }

    .container {
      padding: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    table, th, td {
      border: 1px solid #ccc;
    }

    th, td {
      padding: 10px;
      text-align: center;
    }

    .message {
      text-align: center;
      color: green;
      font-weight: bold;
    }

    .action-form {
      display: inline-block;
    }

    select, button {
      padding: 5px 10px;
      margin: 5px 0;
    }
  </style>
</head>
<body>

  <header>
    <h1>Manage Doctors</h1>
    <div class="nav-buttons">
      <a href="../index.html">Home</a>
      <a href="admin_dashboard.php">Admin Dashboard</a>
      <a href="logout.php">Logout</a>
    </div>
  </header>

  <div class="container">
    <?php if ($message): ?>
      <p class="message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Specialty</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['id']) ?></td>
              <td><?= htmlspecialchars($row['name']) ?></td>
              <td><?= htmlspecialchars($row['specialty']) ?></td>
              <td><?= htmlspecialchars($row['status']) ?></td>
              <td>
                <!-- Status Update Form -->
                <form method="POST" action="" class="action-form">
                  <input type="hidden" name="doctor_id" value="<?= $row['id'] ?>">
                  <select name="status" required>
                    <option value="Active" <?= $row['status'] === 'Active' ? 'selected' : '' ?>>Active</option>
                    <option value="Inactive" <?= $row['status'] === 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                  </select>
                  <button type="submit" name="update_status">Update</button>
                </form>

                <!-- Remove Doctor Form -->
                <form method="POST" action="" class="action-form" onsubmit="return confirm('Are you sure you want to remove this doctor? This will also delete their appointments.');">
                  <input type="hidden" name="doctor_id" value="<?= $row['id'] ?>">
                  <button type="submit" name="remove_doctor">Remove</button>
                </form>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="5">No doctors found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>

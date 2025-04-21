<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit;
}

$user_id = $_SESSION['user_id'];

// Database connection
$host = "localhost";
$user = "root";
$password = "";
$dbname = "medispritus";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch bookings
$appointments = $conn->query("SELECT a.id, d.name AS doctor_name, d.specialty, a.appointment_date, a.status 
    FROM appointments a 
    JOIN doctors d ON a.doctor_id = d.id 
    WHERE a.user_id = $user_id");

$tests = $conn->query("SELECT id, test_name, test_date, status FROM tests WHERE user_id = $user_id");

$nurses = $conn->query("SELECT id, nurse_name, service_date, status FROM nurses WHERE user_id = $user_id");
?>

<?php include('partials/navbar.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Your Bookings</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      background-color: #f5f6fa;
    }

    header {
      background-color: #0984e3;
      color: black;
      padding: 20px;
      text-align: center;
    }

    header h1 {
      margin: 0;
      font-size: 2rem;
    }

    nav ul {
      list-style: none;
      padding: 0;
      margin: 10px 0 0;
      text-align: center;
    }

    nav ul li {
      display: inline-block;
      margin: 0 15px;
    }

    nav ul li a {
      color: white;
      text-decoration: none;
      font-weight: bold;
    }

    nav ul li a:hover {
      text-decoration: underline;
    }

    main {
      padding: 20px;
      max-width: 1000px;
      margin: auto;
    }

    h2 {
      color: #2d3436;
      border-bottom: 2px solid #dfe6e9;
      padding-bottom: 5px;
      margin-top: 30px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
      background-color: white;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    th, td {
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid #dfe6e9;
    }

    th {
      background-color: #74b9ff;
      color: white;
    }

    tr:hover {
      background-color: #f1f2f6;
    }

    .status {
      padding: 5px 10px;
      border-radius: 4px;
      font-weight: bold;
    }

    .status.Pending { background-color: #fdcb6e; color: #2d3436; }
    .status.Confirmed { background-color: #00b894; color: white; }
    .status.Cancelled { background-color: #d63031; color: white; }
  </style>
</head>
<body>

<header>
  <h1>Your Bookings</h1>
  <nav>
    <ul>
      <li><a href="dashboard.php">Dashboard</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </nav>
</header>

<main>
  <h2>Doctor Appointments</h2>
  <table>
    <tr>
      <th>Doctor</th>
      <th>Specialty</th>
      <th>Date</th>
      <th>Status</th>
    </tr>
    <?php while ($row = $appointments->fetch_assoc()) { ?>
      <tr>
        <td><?= htmlspecialchars($row['doctor_name']) ?></td>
        <td><?= htmlspecialchars($row['specialty']) ?></td>
        <td><?= htmlspecialchars($row['appointment_date']) ?></td>
        <td><span class="status <?= htmlspecialchars($row['status']) ?>"><?= htmlspecialchars($row['status']) ?></span></td>
      </tr>
    <?php } ?>
  </table>

  <h2>Medical Tests</h2>
  <table>
    <tr>
      <th>Test Name</th>
      <th>Date</th>
      <th>Status</th>
    </tr>
    <?php while ($row = $tests->fetch_assoc()) { ?>
      <tr>
        <td><?= htmlspecialchars($row['test_name']) ?></td>
        <td><?= htmlspecialchars($row['test_date']) ?></td>
        <td><span class="status <?= htmlspecialchars($row['status']) ?>"><?= htmlspecialchars($row['status']) ?></span></td>
      </tr>
    <?php } ?>
  </table>

  <h2>Nurse Bookings</h2>
  <table>
    <tr>
      <th>Nurse Name</th>
      <th>Date</th>
      <th>Status</th>
    </tr>
    <?php while ($row = $nurses->fetch_assoc()) { ?>
      <tr>
        <td><?= htmlspecialchars($row['nurse_name']) ?></td>
        <td><?= htmlspecialchars($row['service_date']) ?></td>
        <td><span class="status <?= htmlspecialchars($row['status']) ?>"><?= htmlspecialchars($row['status']) ?></span></td>
      </tr>
    <?php } ?>
  </table>
</main>

</body>
</html>

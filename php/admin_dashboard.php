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

$patients = $conn->query("SELECT id, username, email FROM users");
$doctors = $conn->query("SELECT id, name, specialty FROM doctors");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../css/style.css" />
  <style>
    html, body {
      height: 100%;
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      display: flex;
      flex-direction: column;
    }

    header {
      background-color:rgb(64, 73, 73);
      padding: 20px 0;
      text-align: center;
    }

    header h1 {
      margin: 0;
      color: white;
    }

    nav ul {
      list-style: none;
      padding: 0;
      margin: 10px 0 0;
    }

    nav ul li {
      display: inline-block;
      margin: 0 10px;
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
      flex: 1;
      padding: 20px;
      background-color:rgba(218, 225, 212, 0.43);
    }

    h2 {
      color:rgb(254, 255, 255);
      margin-top: 40px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
      background-color: rgb(143, 90, 116);
      box-shadow: 0 0 5px rgba(144, 70, 70, 0.1);
    }

    table th, table td {
      border: 1px solid #ddd;
      padding: 12px;
      text-align: left;
    }

    table th {
      background-color:rgb(120, 101, 152);
      color: black;
    }

    table tr:hover {
      background-color:rgb(121, 180, 172);
    }

    footer {
      background-color:rgb(119, 185, 184);
      color: white;
      text-align: center;
      padding: 10px 0;
    }
  </style>
</head>
<body>

  <header>
    <h1>Admin Dashboard</h1>
    <nav>
      <ul>
        <li><a href="add_doctor.php">Add Doctor</a></li>
        <li><a href="admin_manage_doctors.php">Manage Doctors</a></li>

        <li><a href="admin_manage_appoinments.php">Manage Appointments</a></li>
        <li><a href="view_appoinments.php">View Appoinments</a></li>


        <li><a href="admin_feedback.php">Feedback</a></li>
        <li><a href="logout_admin.php">Logout</a></li>
        
      </ul>
    </nav>
  </header>

  <main>
    <h2>Registered Patients</h2>
    <table>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
      </tr>
      <?php while ($row = $patients->fetch_assoc()) { ?>
      <tr>
        <td><?php echo htmlspecialchars($row['id']); ?></td>
        <td><?php echo htmlspecialchars($row['username']); ?></td>
        <td><?php echo htmlspecialchars($row['email']); ?></td>
      </tr>
      <?php } ?>
    </table>

    <h2>Doctors</h2>
    <table>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Specialty</th>
      </tr>
      <?php while ($row = $doctors->fetch_assoc()) { ?>
      <tr>
        <td><?php echo htmlspecialchars($row['id']); ?></td>
        <td><?php echo htmlspecialchars($row['name']); ?></td>
        <td><?php echo htmlspecialchars($row['specialty']); ?></td>
      </tr>
      <?php } ?>
    </table>
  </main>

  <footer>
    <p>&copy; 2025 Med Visit. All Rights Reserved.</p>
  </footer>

</body>
</html>

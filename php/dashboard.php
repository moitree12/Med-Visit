<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit;
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>User Dashboard</title>
  <link rel="stylesheet" href="../css/style.css">
  <style>
    html, body {
      height: 100%;
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
    }

    body {
      display: flex;
      flex-direction: column;
    }

    header {
      background-color: #8dbab9 ;
      color: white;
      padding: 20px;
      text-align: center;
    }

    nav ul {
      list-style: none;
      display: flex;
      justify-content: center;
      padding: 0;
      margin-top: 10px;
      gap: 20px;
    }

    nav ul li a {
      color: white;
      text-decoration: none;
      font-weight: bold;
      padding: 6px 12px;
    }

    nav ul li a:hover {
      background-color: #019875;
      border-radius: 5px;
    }

    main {
      flex: 1;
      padding: 30px;
      background-color: #f0f4f8;
    }

    main h2,
    main p {
      color: black;
    }

    .dashboard-links {
      list-style: none;
      padding: 0;
    }

    .dashboard-links li {
      margin: 10px 0;
    }

    .dashboard-links li a {
      color: #0984e3;
      font-weight: bold;
      text-decoration: none;
    }

    .dashboard-links li a:hover {
      text-decoration: underline;
    }

    footer {
      background-color: #3f4443;
      color: white;
      text-align: center;
      padding: 15px 0;
      margin-top: auto;
    }
  </style>
</head>
<body>

  <header>
    <h1>Welcome, <?= htmlspecialchars($username) ?>!</h1>
    <nav>
      <ul>
        <li><a href="profile.php">Profile</a></li>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <h2>User Dashboard</h2>
    <p>This is your dashboard. Use the links below to manage your health services.</p>
    <ul class="dashboard-links">
      <li><a href="book_appointment.php">Book an Appointment</a></li>
      <li><a href="book_test.php">Book a Medical Test</a></li>
      <li><a href="book_nurse.php">Book a Nurse</a></li>
      <li><a href="view_booking.php">View Your Bookings</a></li>
      <li><a href="../feedback.html">Write Feedback</a></li>
      <li><a href="user_feedback.php">View Feedback Status</a></li>
    </ul>
  </main>

  <footer>
    <p>&copy; 2025 Med Visit. All Rights Reserved.</p>
  </footer>

</body>
</html>

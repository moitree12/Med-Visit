<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Book a Nurse</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #f0f3f5;
    }

    header {
      background-color: #00b894;
      padding: 20px 0;
      color: white;
      text-align: center;
    }

    header h1 {
      margin: 0;
      font-size: 2rem;
    }

    nav ul {
      list-style: none;
      margin: 15px 0 0;
      padding: 0;
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
      display: flex;
      justify-content: center;
      padding: 30px 15px;
    }

    form {
      background-color: #ffffff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 500px;
    }

    label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
      color: #2d3436;
    }

    input[type="text"],
    input[type="date"] {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
    }

    button {
      margin-top: 20px;
      padding: 10px;
      background-color: #00b894;
      color: white;
      border: none;
      border-radius: 5px;
      font-weight: bold;
      width: 100%;
      cursor: pointer;
    }

    button:hover {
      background-color: #019875;
    }
  </style>
</head>
<body>

<header>
  <h1>Book a Nurse</h1>
  <nav>
    <ul>
      <li><a href="dashboard.php">Dashboard</a></li>
      <li><a href="profile.php">Profile</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </nav>
</header>

<main>
  <form action="process_nurse.php" method="POST">
    <label for="nurse_name">Nurse Name:</label>
    <input type="text" id="nurse_name" name="nurse_name" placeholder="e.g., Jane Doe" required>

    <label for="service_date">Service Date:</label>
    <input type="date" id="service_date" name="service_date" required>

    <button type="submit">Book Nurse</button>
  </form>
</main>

</body>
</html>

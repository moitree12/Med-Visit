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

// Fetch available specialties
$specialties = $conn->query("SELECT DISTINCT specialty FROM doctors");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Book an Appointment</title>
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

    nav ul {
      list-style: none;
      margin: 10px 0 0;
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

    select,
    input[type="date"] {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 5px;
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
  <h1>Book an Appointment</h1>
  <nav>
    <ul>
      <li><a href="dashboard.php">Dashboard</a></li>
      <li><a href="profile.php">Profile</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </nav>
</header>

<main>
  <form action="process_booking.php" method="POST">
    <label for="specialty">Select Specialty:</label>
    <select id="specialty" name="specialty" required>
      <option value="">-- Select a Specialty --</option>
      <?php while ($row = $specialties->fetch_assoc()) { ?>
        <option value="<?= htmlspecialchars($row['specialty']); ?>"><?= htmlspecialchars($row['specialty']); ?></option>
      <?php } ?>
    </select>

    <label for="doctor">Select Doctor:</label>
    <select id="doctor" name="doctor_id" required>
      <option value="">-- Select a Doctor --</option>
      <!-- doctors will be loaded dynamically by AJAX -->
    </select>

    <label for="appointment_date">Appointment Date:</label>
    <input type="date" id="appointment_date" name="appointment_date" required>

    <button type="submit">Book Appointment</button>
  </form>
</main>

<script>
document.getElementById('specialty').addEventListener('change', function() {
  var specialty = this.value;

  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'get_doctors.php', true);
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

  xhr.onload = function () {
    if (this.status == 200) {
      document.getElementById('doctor').innerHTML = this.responseText;
    }
  };

  xhr.send('specialty=' + encodeURIComponent(specialty));
});
</script>

</body>
</html>

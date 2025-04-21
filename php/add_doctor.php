<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.html");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Add Doctor</title>
  <link rel="stylesheet" href="../css/style.css" />
  <style>
    html, body {
      height: 100%;
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
      font-family: Arial, sans-serif;
    }

    header {
      background-color: #8dbab9;
      padding: 20px 0;
      text-align: center;
    }

    header h1 {
      margin: 0;
      color: white;
    }

    .nav-buttons {
      margin-top: 10px;
    }

    .nav-buttons a {
      display: inline-block;
      background-color: white;
      color: #00cec9;
      border: 2px solid white;
      padding: 8px 15px;
      margin: 0 5px;
      border-radius: 5px;
      text-decoration: none;
      font-weight: bold;
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    .nav-buttons a:hover {
      background-color: #019a96;
      color: white;
    }

    main {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    form {
      background-color: #f9f9f9;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      width: 320px;
      display: flex;
      flex-direction: column;
    }

    label {
      margin-top: 10px;
      margin-bottom: 5px;
      color: black;
    }

    input {
      padding: 8px;
      margin-bottom: 10px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    button {
      background-color: #00cec9;
      color: white;
      border: none;
      padding: 10px;
      border-radius: 5px;
      cursor: pointer;
      margin-top: 10px;
    }

    button:hover {
      background-color: #019a96;
    }

    footer {
      background-color:  #3f4443;
      color: white;
      text-align: center;
      padding: 10px 0;
    }
  </style>

  <script>
    function validateDoctorForm() {
      const name = document.getElementById("name").value.trim();
      const specialty = document.getElementById("specialty").value.trim();
      const availability = document.getElementById("availability").value.trim();

      if (!name || !specialty || !availability) {
        alert("Please fill in all fields.");
        return false;
      }

      return true;
    }
  </script>
</head>
<body>

  <header>
    <h1>Add a Doctor</h1>
    <div class="nav-buttons">
      <a href="../index.html">Home</a>
      <a href="admin_dashboard.php">Admin Dashboard</a>
      <a href="logout.php">Logout</a>
    </div>
  </header>

  <main>
    <form action="process_add_doctor.php" method="POST" onsubmit="return validateDoctorForm()">
      <label for="name">Doctor Name:</label>
      <input type="text" id="name" name="name" required>

      <label for="specialty">Specialty:</label>
      <input type="text" id="specialty" name="specialty" required>

      <label for="availability">Availability:</label>
      <input type="text" id="availability" name="availability" placeholder="e.g., Mon-Fri" required>

      <button type="submit">Add Doctor</button>
    </form>
  </main>

  <footer>
    <p>&copy; 2025 Med Visit. All Rights Reserved.</p>
  </footer>
</body>
</html>

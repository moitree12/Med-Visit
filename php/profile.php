<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit;
}

$user_id = $_SESSION['user_id'];


$host = "localhost";
$user = "root";
$password = "";
$dbname = "medispritus";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$query = $conn->prepare("SELECT * FROM users WHERE id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = !empty($_POST['password']) ? md5($_POST['password']) : $user['password'];

    $update = $conn->prepare("UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?");
    $update->bind_param("sssi", $username, $email, $password, $user_id);
    $update->execute();

    echo "<div class='message'>Profile updated successfully!</div>";
    header("Refresh: 2");
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Profile</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #2d3436;
    }

    header {
      background-color: #00b894;
      padding: 10px 0;
    }

    nav ul {
      list-style: none;
      margin: 0;
      padding: 0;
      text-align: center;
    }

    nav ul li {
      display: inline-block;
      margin: 0 20px;
    }

    nav ul li a {
      color: white;
      text-decoration: none;
      font-weight: bold;
      font-size: 16px;
    }

    nav ul li a:hover {
      text-decoration: underline;
    }

    h1 {
      margin-top: 30px;
      text-align: center;
      color: white;
    }

    form {
      background-color: #fff;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 500px;
      margin: 20px auto;
    }

    label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
      color: #2d3436;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
    }

    button {
      margin-top: 20px;
      padding: 10px 20px;
      background-color: #00b894;
      color: white;
      border: none;
      border-radius: 5px;
      font-weight: bold;
      cursor: pointer;
      width: 100%;
    }

    button:hover {
      background-color: #019875;
    }

    .message {
      text-align: center;
      background-color: #dff9fb;
      color: #0984e3;
      padding: 10px;
      margin: 20px auto;
      border-radius: 5px;
      max-width: 500px;
      font-weight: bold;
    }
  </style>
</head>
<body>

<header>
  <nav>
    <ul>
      <li><a href="index.html">Home</a></li>
      <li><a href="profile.php">Profile</a></li>
      <li><a href="dashboard.php">Dashboard</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </nav>
</header>

<h1>Edit Profile</h1>

<form method="POST" action="">
  <label for="username">Name:</label>
  <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>

  <label for="email">Email:</label>
  <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

  <label for="password">New Password:</label>
  <input type="password" id="password" name="password" placeholder="Leave blank to keep current password">

  <button type="submit">Save Changes</button>
</form>

</body>
</html>

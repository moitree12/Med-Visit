<?php
// Database connection
$host = "localhost";
$user = "root";
$password = "";
$dbname = "medispritus";

$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $username = htmlspecialchars(trim($_POST['username']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check for empty fields
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $message = "All fields are required.";
    } 
    // Validate email format
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format.";
    }
    // Check password match
    elseif ($password !== $confirm_password) {
        $message = "Passwords do not match.";
    } 
    else {
        // Check if email already exists
        $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            $message = "Email is already registered. Try logging in.";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert user into the database
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashed_password);

            if ($stmt->execute()) {
                $message = "Registration successful! <a href='../login.html'>Login here</a>";
                $success = true;
            } else {
                $message = "Registration failed: " . $stmt->error;
            }

            $stmt->close();
        }

        $checkStmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Registration Result</title>
  <link rel="stylesheet" href="../css/style.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 40px;
      background-color: #f0f4f8;
      text-align: center;
    }
    .message {
      padding: 20px;
      margin: 30px auto;
      max-width: 500px;
      border-radius: 10px;
      font-size: 18px;
    }
    .success {
      background-color: #dff0d8;
      color: #3c763d;
    }
    .error {
      background-color: #f2dede;
      color: #a94442;
    }
    a {
      color: #007BFF;
      text-decoration: none;
      font-weight: bold;
    }
    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="message <?= isset($success) && $success ? 'success' : 'error' ?>">
    <?= isset($message) ? $message : "Something went wrong." ?>
  </div>
</body>
</html>

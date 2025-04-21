<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.html");
    exit();
}

if (!isset($_GET['feedback_id']) || empty($_GET['feedback_id'])) {
    die("Feedback ID is missing.");
}

$feedback_id = $_GET['feedback_id'];

// DB Connection
$host = "localhost";
$user = "root";
$password = "";
$dbname = "medispritus";
$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$feedback = null;

// Fetch feedback
$query = $conn->prepare("SELECT feedback_text, reply FROM feedback WHERE id = ?");
$query->bind_param("i", $feedback_id);
$query->execute();
$result = $query->get_result();
if ($result && $result->num_rows > 0) {
    $feedback = $result->fetch_assoc();
} else {
    die("No feedback found with that ID.");
}

// Handle POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reply = $_POST['reply'];

    $update = $conn->prepare("UPDATE feedback SET reply = ?, status = 'Replied' WHERE id = ?");
    $update->bind_param("si", $reply, $feedback_id);
    if ($update->execute()) {
        header("Location: admin_feedback.php?success=1");
        exit();
    } else {
        echo "Error updating reply.";
    }
    $update->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Reply to Feedback</title>
  <link rel="stylesheet" href="../css/style.css" />
  <style>
    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
      display: flex;
      flex-direction: column;
      font-family: Arial, sans-serif;
    }
    header {
      background-color: #00cec9;
      color: white;
      padding: 20px;
      text-align: center;
    }
    nav ul {
      list-style: none;
      padding: 0;
      margin-top: 10px;
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
    main {
      flex: 1;
      padding: 20px;
      background-color: #f5f5f5;
    }
    .feedback-section {
      color: black; 
    }
    textarea {
      width: 100%;
      max-width: 600px;
    }
    button {
      margin-top: 10px;
      padding: 8px 16px;
      background-color: #00cec9;
      color: white;
      border: none;
      cursor: pointer;
    }
    button:hover {
      background-color: #009fa4;
    }
    footer {
      background-color: #00cec9;
      color: white;
      text-align: center;
      padding: 10px 0;
    }
  </style>
</head>
<body>

  <header>
    <h1>Admin - Reply to Feedback</h1>
    <nav>
      <ul>
        <li><a href="admin_dashboard.php">Dashboard</a></li>
        <li><a href="admin_feedback.php">Back to Feedback</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <h2 class="feedback-section">Feedback</h2>
    <div class="feedback-section">
      <p><strong>User's Feedback:</strong> <?= nl2br(htmlspecialchars($feedback['feedback_text'])) ?></p>
    
      <form method="POST" action="">
        <label for="reply"><strong>Admin Reply:</strong></label><br>
        <textarea name="reply" rows="5" required><?= htmlspecialchars($feedback['reply']) ?></textarea><br>
        <button type="submit">Submit Reply</button>
      </form>
    </div>
  </main>

  <footer>
    <p>&copy; 2025 MediSpritus. All Rights Reserved.</p>
  </footer>

</body>
</html>

<?php $conn->close(); ?>

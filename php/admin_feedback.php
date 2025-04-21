<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.html");
    exit();
}

$host = "localhost";
$user = "root";
$password = "";
$dbname = "medispritus";
$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = $conn->prepare("SELECT f.id, u.username, f.feedback_text, f.reply, f.created_at, f.status 
                         FROM feedback f 
                         JOIN users u ON f.user_id = u.id 
                         ORDER BY f.created_at DESC");
$query->execute();
$result = $query->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Feedback Management</title>
  <link rel="stylesheet" href="../css/style.css">
  <style>
    html, body {
      height: 100%;
      margin: 0;
    }

    body {
      display: flex;
      flex-direction: column;
      font-family: Arial, sans-serif;
    }

    header {
      background-color: #8dbab9;
      color: white;
      padding: 20px;
      text-align: center;
    }

    nav ul {
      list-style: none;
      padding: 0;
      margin: 10px 0 0;
      display: flex;
      justify-content: center;
      gap: 20px;
    }

    nav ul li a {
      text-decoration: none;
      color: #00cec9;
      background-color: white;
      padding: 8px 16px;
      border-radius: 5px;
      font-weight: bold;
    }

    nav ul li a:hover {
      background-color: #019a96;
      color: white;
    }

    main {
      flex: 1;
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
      text-align: left;
    }

    td:nth-child(2), td:nth-child(3) {
      white-space: pre-line;
    }

    td a {
      color: #00b894;
      text-decoration: none;
      font-weight: bold;
    }

    td a:hover {
      text-decoration: underline;
    }

    footer {
      text-align: center;
      background-color: #00cec9;
      color: white;
      padding: 10px 0;
    }
  </style>
</head>
<body>

<header>
  <h1>Admin - Feedback Management</h1>
  <nav>
    <ul>
      <li><a href="../index.html">Home</a></li>
      <li><a href="admin_dashboard.php">Dashboard</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </nav>
</header>

<main>
  <h2>User Feedback</h2>
  <table>
    <thead>
      <tr>
        <th>User</th>
        <th>Feedback</th>
        <th>Reply</th>
        <th>Status</th>
        <th>Date Submitted</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result->num_rows > 0): ?>
        <?php while ($feedback = $result->fetch_assoc()): ?>
          <tr>
          <tr>
  <td><?= htmlspecialchars($feedback['username']) ?></td>
  <td><?= nl2br(htmlspecialchars($feedback['feedback_text'])) ?></td>
  <td><?= $feedback['reply'] ? nl2br(htmlspecialchars($feedback['reply'])) : '<em>No reply yet</em>' ?></td>
  <td><?= $feedback['reply'] ? 'Resolved' : 'Unresolved' ?></td>
  <td><?= date("F j, Y, g:i a", strtotime($feedback['created_at'])) ?></td>
  <td><a href="reply_feedback.php?feedback_id=<?= $feedback['id'] ?>">Reply</a></td>
</tr>

          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="6" style="text-align: center;">No feedback available.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</main>

<footer>
  <p>&copy; 2025 Med Visit. All Rights Reserved.</p>
</footer>

</body>
</html>

<?php
$conn->close();
?>

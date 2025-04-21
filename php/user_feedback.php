<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Database connection
$host = "localhost";
$user = "root";
$password = "";
$dbname = "medispritus";
$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the user's feedback
$query = $conn->prepare("SELECT feedback_text, reply, status FROM feedback WHERE user_id = ?");
$query->bind_param("i", $_SESSION['user_id']);
$query->execute();
$result = $query->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Feedback</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        html, body {
            margin: 0;
            padding: 0;
            min-height: 100%;
            display: flex;
            flex-direction: column;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        header {
            background-color: #6789a4;
            color: white;
            padding: 20px;
            text-align: center;
        }

        nav ul {
            list-style: none;
            padding: 0;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        nav a {
            color: white;
            text-decoration: none;
        }

        main {
            flex: 1;
            padding: 20px;
            color: white; /* Set main content text to black */
        }

        h2, p, strong {
            color: #white; /* Explicitly set heading and text to black */
        }

        footer {
            background-color:rgb(203, 213, 218);
            text-align: center;
            padding: 15px;
            color: #2d3436;
        }
    </style>
</head>
<body>

    <header>
        <h1>Your Feedback</h1>
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Submitted Feedback</h2>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($feedback = $result->fetch_assoc()) { ?>
                <p><strong>Feedback:</strong> <?= nl2br(htmlspecialchars($feedback['feedback_text'])) ?></p>
                <p><strong>Reply:</strong> <?= nl2br(htmlspecialchars($feedback['reply'])) ?: 'No reply yet.' ?></p>
                <hr>
            <?php } ?>
        <?php else: ?>
            <p>No feedback submitted yet.</p>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2025 Med Visit. All Rights Reserved.</p>
    </footer>

</body>
</html>

<?php
$conn->close();
?>

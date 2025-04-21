<?php
session_start();


$host = "localhost";
$user = "root";
$password = "";
$dbname = "medispritus";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $username = $_POST['username'];
    $password = $_POST['password']; 

    
    $query = $conn->prepare("SELECT * FROM admins WHERE username = ? AND password = ?");
    $query->bind_param("ss", $username, $password);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        $_SESSION['admin_id'] = $admin['id']; 
        header("Location: admin_dashboard.php");
        exit;
    } else {
        echo "Invalid username or password.";
    }

    $query->close();
}

$conn->close();
?>

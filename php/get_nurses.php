<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "medispritus";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT id, name FROM nurses");

if ($result->num_rows > 0) {
    echo '<option value="">-- Select a Nurse --</option>';
    while ($row = $result->fetch_assoc()) {
        echo '<option value="'. $row['name'] .'">'. htmlspecialchars($row['name']) .'</option>';
    }
} else {
    echo '<option value="">No nurses available</option>';
}
?>

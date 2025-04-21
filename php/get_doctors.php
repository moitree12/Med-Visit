<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "medispritus";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['specialty'])) {
    $specialty = $conn->real_escape_string($_POST['specialty']);

    $result = $conn->query("SELECT id, name FROM doctors WHERE specialty='$specialty'");

    if ($result->num_rows > 0) {
        echo '<option value="">-- Select a Doctor --</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="'.$row['id'].'">'.htmlspecialchars($row['name']).'</option>';
        }
    } else {
        echo '<option value="">No doctors available</option>';
    }
}
?>

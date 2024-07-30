<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "quizprojecty3";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

$userId=$_GET['userId'];
$email=$_GET['email'];
$password=$_GET['password'];
$sql = "UPDATE user SET email='$email', password='$password' WHERE userId=$userId";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Done update.')</script>";
    header('Location: admin_panel.php');
   // echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error]);
}

$conn->close();

?>

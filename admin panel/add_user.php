<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "quizprojecty3";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) { 
    //  => is double arrow operator
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

$email=$_GET['email'];
$password=$_GET['password'];
$sql = "INSERT INTO user ( email, password) VALUES ( '$email', '$password')";

if ($conn->query($sql) === TRUE) {
    $id = $conn->insert_id;
 //   echo json_encode(['success' => true, 'id' => $id]);
    header('Location: admin_panel.php');
} else {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error]);
}

$conn->close();


?>


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

$historyUpdate="update history set userid=Null  where userid=$userId";

$leaderboard="update leaderboard set userid=Null  where userid=$userId";
$usercategory="update usercategory set userid=Null  where userid=$userId";
$conn->query($leaderboard);
$conn->query($usercategory);
if ($conn->query($historyUpdate) === TRUE) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error]);
}

$sql = "DELETE FROM user WHERE userId=$userId";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Done deletion.')</script>";
    header('Location: admin_panel.php');
    // echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error]);
}

$conn->close();
?>

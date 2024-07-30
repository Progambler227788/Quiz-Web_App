<?php
// Ensure all necessary data is provided via GET request
if (!isset($_GET['quizName']) || !isset($_GET['categoryId']) || !isset($_GET['quizId'])) {
    die("Error: Required parameters are missing.");
}

$servername = "localhost";
$username = "root";
$passwordSql = "";
$database = "quizprojecty3";

// Connect to database
$conn = new mysqli($servername, $username, $passwordSql, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare data from GET parameters
$quizName = $_GET['quizName'];
$categoryId = $_GET['categoryId'];
$quizId = $_GET['quizId'];

// Update quiz in the database
$sqlUpdateQuiz = "UPDATE quiz SET quizName = ?, categoryId = ? WHERE quizId = ?";
$stmt = $conn->prepare($sqlUpdateQuiz);
$stmt->bind_param("sii", $quizName, $categoryId, $quizId);

if ($stmt->execute()) {
    echo "Quiz updated successfully.";
} else {
    echo "Error updating quiz: " . $conn->error;
}

$stmt->close();
?>

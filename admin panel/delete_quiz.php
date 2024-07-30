<?php
// Ensure quizId is provided via GET request
if (!isset($_GET['quizId'])) {
    die("Error: Required parameter 'quizId' is missing.");
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

// Prepare quizId from GET parameter
$quizId = $_GET['quizId'];

// Delete associated records from quizQuestion table first
$sqlDeleteQuizQuestions = "DELETE FROM quizQuestion WHERE quizId = $quizId";

if ($conn->query($sqlDeleteQuizQuestions) === TRUE) {
    // If associated quiz questions are deleted successfully, delete the quiz from quiz table
    $sqlDeleteQuiz = "DELETE FROM quiz WHERE quizId = $quizId";
    if ($conn->query($sqlDeleteQuiz) === TRUE) {
        echo "Quiz and associated questions deleted successfully.";
    } else {
        echo "Error deleting quiz: " . $conn->error;
    }
} else {
    echo "Error deleting associated questions: " . $conn->error;
}

$conn->close();
?>

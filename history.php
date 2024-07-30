<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuizZone</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS/history.css">
</head>
<body>

<?php

$servername = "localhost";
$username = "root";
$passwordSql = "";
$database = "quizprojecty3";

// Connect to database
$conn = new mysqli($servername, $username, $passwordSql, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
$userId = $_SESSION['userId'];
$historyQuery = "SELECT * FROM history WHERE userId=$userId";
$historyResult = $conn->query($historyQuery);

// Initialize variables
$correctAnswers = 0;
$wrongAnswers = 0;
$successRate = 0;
$totalQuiz = 0;
$favoriteCategory = '';

// Get the most occurring category for the user
$userCategoryQuery = "SELECT categoryId FROM usercategory WHERE userId = $userId
                      GROUP BY categoryId
                      ORDER BY COUNT(categoryId) DESC
                      LIMIT 1";

$fvrtResult = $conn->query($userCategoryQuery);

if ($fvrtResult && $fvrtResult->num_rows > 0) {
    $fvrtCategoryData = $fvrtResult->fetch_assoc();
    $fvrtCategoryId = $fvrtCategoryData['categoryId'];

    // Fetch the category name from the category table
    $fvrtQuery = "SELECT categoryname FROM category WHERE categoryid=$fvrtCategoryId";
    $categoryNameResult = $conn->query($fvrtQuery);

    if ($categoryNameResult && $categoryNameResult->num_rows > 0) {
        $categoryNameData = $categoryNameResult->fetch_assoc();
        $favoriteCategory = $categoryNameData['categoryname'];
    }
}

// Fetch user history data
if ($historyResult && $historyResult->num_rows > 0) {
    $historyData = $historyResult->fetch_assoc();
    $correctAnswers = $historyData['CorrectAnswers'];
    $wrongAnswers = $historyData['WrongAnswers'];
    $successRate = $historyData['SuccessRate'];
    $totalQuiz = $historyData['TotalQuiz'];
}
?>

<!-- Main Content -->
<div class="container text-center mt-5">
    <h1>Quiz<span class="heading">Zone</span></h1>
    <div class="stats mt-4">
        <div class="stat-item p-3 my-2">
            <span>Correct Answers:</span>
            <span><?php echo $correctAnswers; ?></span>
        </div>
        <div class="stat-item p-3 my-2">
            <span>Wrong Answers:</span>
            <span><?php echo $wrongAnswers; ?></span>
        </div>
        <div class="stat-item p-3 my-2">
            <span>Success Rate%:</span>
            <span><?php echo $successRate; ?></span>
        </div>
        <div class="stat-item p-3 my-2">
            <span>Total Quiz:</span>
            <span><?php echo $totalQuiz; ?></span>
        </div>
        <div class="stat-item p-3 my-2">
            <span>Favorite Category:</span>
            <span><?php echo $favoriteCategory; ?></span>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="history.js"></script>
</body>
</html>

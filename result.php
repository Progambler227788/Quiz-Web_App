<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link rel="stylesheet" href="CSS/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
$email= $_SESSION['email'];
$userId= $_SESSION['userId'];
$score=$_GET['score'];
$scorePer=($score/10)*100;
$insertQuery = "INSERT INTO leaderboard (userId, username,attemptedTime, userScore, userScorePercentage) 
                VALUES ($userId, '$email', CURRENT_TIMESTAMP, $score, $scorePer)";
$conn->query($insertQuery);

//history update

$wrongAsnwers=10-$score;

$HistoryQuery="update history set wrongAnswers=wrongAnswers+$wrongAsnwers,correctAnswers=correctAnswers+$score,TotalQuiz=TotalQuiz+1 where userId=$userId ";

if($conn->query($HistoryQuery)===True){
    echo 'history updated';
}
else {
    echo 'history Not updated';
}

$HistoryQuery="update history set successRate=(correctAnswers/(correctAnswers+wrongAnswers))*100 where userId=$userId ";

if($conn->query($HistoryQuery)===True){
    echo 'history updated';
}
else {
    echo 'history Not updated';
}


?>

<!-- Header Section -->

<!--  Navigation bar -->
<!-- ms for margin start -->
<!-- mt for margin top -->
<!-- d-flex for display flex -->
<!-- primary for blue, secondary for grey color, info for light blue -->
<!-- fw for font weight-->
<div class="container text-center">
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex justify-content-center align-items-center flex-grow-1">
            <p id="quiz" class="mb-0 display-5">Quiz</p>
            <p id="zone" class="mb-0 ms-1 display-5 text-info">Zone</p>

        </div>
    </div> 
    <div class="score1 mt-4 d-flex justify-content-center align-items-center text-black">
        <h3 class="text-black"><b>Your score</b></h3>
        <div class="ellipse text-black"><?php 
                echo $_GET['score']; ?></div>
    </div>
</div>
<div class="mt-4  text-center justify-content-center align-items-center text-black">
    <h3 class="divMargin "><b>"Keep Learning, You have great score!"</b></h3>
</div>

<div class="mt-2 d-flex justify-content-center align-items-center text-black">
    <button id="start" class="complete btn btn-outline-dark mt-4 justify-content-end  complete1" onclick="location.href='index.php'">Complete</button>
    <button id="start" class="btn btn-outline-dark mt-4 justify-content-end  complete1" onclick="location.href='category.html'">Play Again</button>
     
</div>

</body>
</html>

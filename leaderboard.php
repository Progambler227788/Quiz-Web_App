<?php
session_start();
$isLoggedIn = isset($_SESSION['userId']);
$username = $isLoggedIn ? $_SESSION['email'] : '';

// Check if username contains '@'
if (strpos($username, '@') !== false) {
  // Trim characters after '@', including '@' itself
  $username = strstr($username, '@', true); // Get the substring before '@'
}
?>

<!-- Note for farman -> table bna dya ha leaderboard ka us m attemptedTime b dal dya ha -->
<!-- har user k id k lihaz se sab score nikal leader board se phly join laga dy chaye   -->
<!-- sab se phly jab result.php page load hu tu leaderboard table m data add krwa dy  -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <link rel="stylesheet" href="CSS/abdullah.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    
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

// Fetch the top 5 scores from the leaderboard table
$getQuery = 'SELECT *  FROM leaderboard group by userId ORDER BY userScore DESC LIMIT 5';
$boardResult = $conn->query($getQuery);

include("navbar.php");
?>

<div class="container mt-5">
    <h1 class="heading">Leaderboard of <span>Users</span></h1>
    <table class="table table-bordered leaderboard-table">
        <thead>
            <tr>
                <th>Pos.</th>
                <th>Name</th>
                <th>Entered on</th>
                <th>Points</th>
                <th>Result</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($boardResult->num_rows > 0) {
                $position = 1;
                while ($row = $boardResult->fetch_assoc()) {
                    $enteredOn = date('M d, Y @ H:i', strtotime($row['attemptedTime']));
                    $points = $row['userScore'];
                    $result = number_format($row['userScorePercentage'], 2) . " %";
                    echo "<tr>
                            <td>{$position}</td>
                            <td>{$row['username']}</td>
                            <td>{$enteredOn}</td>
                            <td>{$points}</td>
                            <td>{$result}</td>
                          </tr>";
                    $position++;
                }
            } else {
                echo "<tr><td colspan='5'>No data available</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script  src="JS/script.js"></script>

<?php 
include("footer.php");
?>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>

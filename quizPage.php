<?php
$category = $_GET['category'];

$servername = "localhost";
$username = "root";
$passwordSql = "";
$database = "quizprojecty3";

// Connect to database
$conn = new mysqli($servername, $username, $passwordSql, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function fetchQuizData($conn, $category) {
    $selectQuery = 'SELECT categoryId FROM category WHERE categoryName="' . $category . '"';
    $result = $conn->query($selectQuery);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $categoryId = $row['categoryId'];

        $quesQuery = 'SELECT * FROM question WHERE categoryId=' . $categoryId;
        $result = $conn->query($quesQuery);

        //updating user Category 
        session_start();
        $userId=$_SESSION['userId'];
        $userCategoryQuery="Insert into userCategory (userid,categoryid)
                            values ($userId,$categoryId)";
        if($conn->query($userCategoryQuery)=== True){
            echo "Succesfully uodate user cat";
        }
        else{
            echo "Succesfully not uodate user cat";
        }



        if ($result && $result->num_rows > 0) {
            $questions = array();
            while ($row = $result->fetch_assoc()) {
                $questions[] = $row;
            }
            return $questions; // Return the array of questions
        } else {
            return null; // No questions found
        }
    } else {
        return null; // Category not found
    }
}

// Fetch all quiz data
$quizData = fetchQuizData($conn, $category);

?>


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


<!-- Header Section -->
<div class="container text-center">
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex justify-content-center align-items-center flex-grow-1">
            <p id="quiz" class="mb-0 display-5">Quiz</p>
            <p id="zone" class="mb-0 ms-1 display-5 text-info">Zone</p>
        </div>
        <div class="d-flex flex-column align-items-center">
            <img src="Images/volume-up-interface-symbol.png" alt="Volume" class="img-fluid mt-5" style="height: 50px; width: 50px;">
            <div class="mt-2">
                <h1 id='scoreNumber'><span class="badge start1 text-black">02/25</span></h1>
            </div>
        </div>
    </div>
</div>

<div id='question' class="alert alert-light container mt-4 text-black bg-white" role="alert">
    What do you mean by HTML?
</div>

<div class="container text-end mt-2">
    <h1><span id="timer" class="badge start1 text-black">30s</span></h1>
</div>

<div class="alert alert-light container mt-4">
    <div id='option1' class="alert alert-light container mt-4 text-black option">
        Speaking Language
    </div>
    <div id='option2' class="alert alert-light container mt-4 text-black option">
        Game
    </div>
    <div id='option3' class="alert alert-light container mt-4 text-black option">
        School
    </div>
    <div id='option4' class="alert alert-light container mt-4 text-black option">
        Programming
    </div>
</div>

<!-- <div class="container text-end mt-2">
    <button id="start" class="btn btn-outline-dark mt-4 justify-content-end start1 next1" onclick="nextQuestion()">Next</button>
</div> -->

<?php 
include("footer.php");
?>

<script>
    // Timer
    var questions = <?php echo json_encode($quizData); ?>;
    var currentIndex = 0;
    var score = 0;

    function updateScoreDisplay() {
        var scoreDisplay = document.getElementById('scoreNumber');
        scoreDisplay.innerHTML = '<span class="badge start1 text-black">' + pad(currentIndex+1) + '/' + pad(10) + '</span>';
    }

    // Function to randomly shuffle elements in an array
    function randomlyShiftArray(arr) {
    var len = arr.length;
    for (var i = 0; i < len; i++) {
        // Generate random index within the array bounds
        var randomIndex1 = Math.floor(Math.random() * len);
        var randomIndex2 = Math.floor(Math.random() * len);

        // Swap elements at randomIndex1 and randomIndex2
        var temp = arr[randomIndex1];
        arr[randomIndex1] = arr[randomIndex2];
        arr[randomIndex2] = temp;
    }
}
    randomlyShiftArray( questions );

    function displayQuestion(index) {
        var question = questions[index];
        document.getElementById('question').innerText = question.questionText;
        document.getElementById('option1').innerText = question.option1;
        document.getElementById('option2').innerText = question.option2;
        document.getElementById('option3').innerText = question.option3;
        document.getElementById('option4').innerText = question.option4;

        var correctAnswer = question.correctAnswer;

        var options = document.querySelectorAll('.option');
        options.forEach(function(option) {
            option.style.backgroundColor = 'white';
            option.onclick = function() {
                if (this.innerText === correctAnswer) {
                    this.style.backgroundColor = 'green';
                    score++;
                    nextQuestion()
                } else {
                    this.style.backgroundColor = 'red';
                    nextQuestion()
                }
              
            };
        });
    }

    function nextQuestion() {
      
        currentIndex++;
        
        if (currentIndex < 10) {
            displayQuestion(currentIndex);
            updateScoreDisplay();
            stopTimer();
            startTimer(1);
        } else {
            alert("Quiz completed! Your score is: " + score);
            window.location.href = "result.php?score=" + score;
        }
    }

var x; // Variable to hold the timer interval reference

    function startTimer(second) {// Set the date we're counting down to
    var adding_seconds = 31000
        if (second==1){
            adding_seconds +=1000 ; // l paramter is used to increase one second for options after 1st option
        }

var countDownDate = new Date().getTime() + adding_seconds; // taking next 31 seconds so that 1 second for calculation

// Update the count down every 1 second
x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();
    
  // Find the distance between now and the count down date
  var distance = countDownDate - now;
    
  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  // Output the result in an element 
  document.getElementById("timer").innerHTML =  seconds + "s";
    
  // If the count down is over
  if (distance <= 0) {
    clearInterval(x);
    nextQuestion();
    document.getElementById("timer").innerHTML =   "30s";
    
  }
}, 1000);
    }

    function pad(val) {
        return val > 9 ? val : "0" + val;
    }

    // Function to stop the timer
function stopTimer() {
    clearInterval(x); // Stop the timer interval
    
}


    // Initialize the first question
    displayQuestion(currentIndex);
    updateScoreDisplay();

    startTimer(0);
</script>


</body>
</html> 
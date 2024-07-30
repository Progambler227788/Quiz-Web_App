<?php
session_start();

// Database connection settings
$servername = "localhost"; 
$username = "root"; 
$passwordSql = ""; 
$database = "quizprojecty3";

// Function to sanitize input data
function sanitizeData($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to handle login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    // Validate email and password
    $email = sanitizeData($_POST['email']);
    $password = sanitizeData($_POST['password']);

    // Connect to database
    $conn = new mysqli($servername, $username, $passwordSql, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL query
    $sql = "SELECT userId, email, password FROM user WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // User found, verify password
        $row = $result->fetch_assoc();
        
        if (($password === $row['password'])) {
            // Password is correct, start session
            $_SESSION['userId'] = $row['userId'];
            $_SESSION['email'] = $row['email'];
            header("Location: index.php"); // Redirect to index.php on successful login
            exit();
        } else {
            // Invalid password
            echo "<script>alert('Invalid login credentials.')</script>";
           
        }
    } else {
        // User not registered
        echo "<script>alert('User -> not registered.')</script>";
        
        
    }

    // Close connection
    $conn->close();
}

// Function to handle signup
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    // Validate email and password
    $email = sanitizeData($_POST['email']);
    $password = sanitizeData($_POST['password']);

    

    // Connect to database
    $conn = new mysqli($servername, $username, $passwordSql, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL query to insert user
    $sql = "INSERT INTO user (email, password) VALUES ('$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        // Registration successful
         $userId = $conn->insert_id; // Get the ID of the inserted user
         $insertHistory="INSERT INTO history (userId,CorrectAnswers,WrongAnswers,SuccessRate,TotalQuiz)
                          values ($userId,0,0,0,0) ";
        $conn->query($insertHistory);
         // Store user ID and email in session
         session_start();
         $_SESSION['userId'] = $userId;
         $_SESSION['email'] = $email;
 
         echo "<script>alert('Registration successful. Please login.')</script>";
         header("Location: index.php"); // Redirect to index.php on successful login
         exit();
    } else {
        // Registration failed
        echo "<script>alert('Error: " . $conn->error . "')</script>";
    }

    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Boostrap CDN  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/abdullah.css">


</head>

<body>
    <div class="container d-grid align-items-center justify-content-center min-vh-100 w-auto">
        <div class="main-section">
            <div class="heading">
                <p class="font-14-r fw-normal text-center">Welcome back!</p>
                <p class="font-14-r fw-normal text-center"> Please login/Signup to your account.</p>
            </div>
            <!-- Login form  -->
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-floating form-box">
                    <input type="email" class="form-control form-input fw-semibold" id="floatingInput"
                        placeholder="name@example.com" name="email" required>
                    <label for="floatingInput" class="font-14-r fw-normal">Email address</label>
                </div>
                <div class="form-floating mt-4 form-box">
                    <input type="password" class="form-control form-input fw-semibold" id="maskedPassword"
                        placeholder="*******************" name="password" required>
                    <input type="hidden" id="realPassword" name="password">
                    <label for="maskedPassword" class="font-14-r fw-normal">Password</label>
                </div>
                <div class="row form-footer">
                    <!-- <div class="col">
                        <input type="checkbox" class="form-check-input form-box" name="checkbox">
                        <label for="checkbox" class="form-label font-14-r fw-normal">Remember Me</label>
                    </div> -->
                    <div class="col text-end"><a href="#" class="font-14-r fw-normal text-decoration-none">
                            Password?
                        </a>
                    </div>
                </div>

                <div class="action-button">
                    <button type="submit" class="fw-normal" name="login">Login</button>
                    <button type="submit" class="fw-normal" name="signup">Signup</button>
                </div>
            </form>
            <!-- Login form  -->
        </div>
    </div>


    <!-- JS Script  -->
    <script>
        // function to change dot(.) to star(*) in password field according to Figma Design 
        document.getElementById('maskedPassword').addEventListener('input', function () {
            const maskedInput = document.getElementById('maskedPassword');
            const realInput = document.getElementById('realPassword');
            const realValue = realInput.value;
            const newValue = maskedInput.value;

            if (newValue.length > realValue.length) {
                const addedChar = newValue[newValue.length - 1];
                realInput.value += addedChar;
            } else if (newValue.length < realValue.length) {
                realInput.value = realValue.substring(0, realValue.length - 1);
            }

            maskedInput.value = '*'.repeat(realInput.value.length);
        });
    </script>
    <!-- JS Script  -->
</body>

</html>

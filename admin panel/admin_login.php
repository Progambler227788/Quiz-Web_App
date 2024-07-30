<?php
session_start();

// Database connection settings
$servername = "localhost";
$username1 = "root";
$password1 = "";
$database = "quizprojecty3";

// Function to sanitize input data
function sanitizeData($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to handle admin login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    // Validate username and password
    $username = sanitizeData($_POST['username']);
    $password = sanitizeData($_POST['password']);

    // Connect to database
    $conn = new mysqli($servername, $username1, $password1, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL query
    $sql = "SELECT id, username, password FROM admin WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Admin found, verify password
        $row = $result->fetch_assoc();
        
        if ($password === $row['password'] ) {
            // Password is correct, start session
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_username'] = $row['username'];
            header("Location: admin_panel.php"); 
            exit();
        } else {
            // Invalid password
            echo "<script>alert('Invalid login credentials.')</script>";
        }
    } else {
        // Admin not registered
        echo "<script>alert('Admin not registered.')</script>";
    }

    // Close connection
    $conn->close();
}

// Function to handle admin signup
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
                    <input type="text" class="form-control form-input fw-semibold" id="username"
                        placeholder="Username" name="username" required>
                    <label for="username" class="font-14-r fw-normal">Username</label>
                </div>
                <div class="form-floating mt-4 form-box">
                    <input type="password" class="form-control form-input fw-semibold" id="maskedPassword"
                        placeholder="*******************" name="password" required>
                    <label for="maskedPassword" class="font-14-r fw-normal">Password</label>
                </div>

                <div class="action-button">
                    <button type="submit" class="fw-normal mt-3 ms-1" name="login">Login</button>
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

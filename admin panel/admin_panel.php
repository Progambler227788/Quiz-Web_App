<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<?php

session_start();

// Check if admin session variables are set
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_username'])) {
    // Redirect to login page or display an error message
    echo "<script> window.location.href = 'admin_login.php';</script>";
    exit();
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

// for Dashboard data
$sqlTotalUsers = "SELECT COUNT(*) AS total_users FROM user";
$sqlTotalQuizzes = "SELECT COUNT(*) AS total_quizzes FROM category";
$sqlTotalQuestions = "SELECT COUNT(*) AS total_questions FROM question";

$totalUsers = $conn->query($sqlTotalUsers)->fetch_assoc()['total_users'];
$totalQuizzes = $conn->query($sqlTotalQuizzes)->fetch_assoc()['total_quizzes'];
$totalQuestions = $conn->query($sqlTotalQuestions)->fetch_assoc()['total_questions'];

// for users
$userSelect = "SELECT * FROM user";
$result = $conn->query($userSelect);
$users = array();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

// Talha section ---------------------------------
//A LEFT JOIN ensures that all rows from the left table (quiz in this case) are included in the result set, 
//regardless of whether there is a matching row in the right table (category). This means if a quiz does 
//not have an associated category (categoryId is NULL), it will still be included in the result with a 
//NULL value for categoryName.
//This is suitable because quizzes might exist without being assigned to a category, and you still want 
//to fetch those quizzes.
// SQL query to fetch quizzes with category names
$sql = "SELECT q.quizId, q.quizName, c.categoryName
        FROM quiz q
        LEFT JOIN category c ON q.categoryId = c.categoryId";

$result = $conn->query($sql);

$quizzes = array();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $quizzes[] = $row;
    }
} else {
    echo "No quizzes found.";
}
// ----------------------------------------


?>
    <div id="sidebar" class="d-flex flex-column p-3">
        <h2 class="text-center title-colored"><span class="quiz">Quiz</span><span class="zone">Zone</span></h2>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="#" class="nav-link active" id="dashboard-link">Dashboard</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link" id="user-link">Users</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link" id="quiz-link">Quiz</a>
            </li>
            <li class="nav-item">
                <a href="logout.php" class="nav-link" id="logout-link">Logout</a>
            </li>
        </ul>
    </div>
    <div id="content">
        <div id="main-content"></div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="add-user-form">
                        <div class="mb-3">
                            <label for="add-user-name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="add-user-name" required>
                        </div>
                        <div class="mb-3">
                            <label for="add-user-email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="add-user-email" required>
                        </div>
                        <div class="mb-3">
                            <label for="add-user-password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="add-user-password" required>
                        </div>
                        <button type="submit" class="btn btn-add-user">Add User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script>
        const users = <?php echo json_encode($users); ?>;

        document.getElementById('dashboard-link').addEventListener('click', function() {

            document.querySelectorAll('.nav-link').forEach(link => { 
        link.classList.remove('active');
    });

    // Add 'active' class to the clicked nav item
    this.classList.add('active');
            document.getElementById('main-content').innerHTML = `
                <h2>Dashboard</h2>
                <div class="dashboard-info">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Total Students</h5>
                            <p class="card-text"><?php echo $totalUsers; ?></p>
                        </div>
                    </div>
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Total Quiz Categories</h5>
                            <p class="card-text"><?php echo $totalQuizzes; ?></p>
                        </div>
                    </div>
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Total Questions</h5>
                            <p class="card-text"><?php echo $totalQuestions; ?></p>
                        </div>
                    </div>
                </div>
            `;
        });

        document.getElementById('user-link').addEventListener('click', function() {
        // Changed by talha
            document.querySelectorAll('.nav-link').forEach(link => { 
        link.classList.remove('active');
    });

    // Add 'active' class to the clicked nav item
    this.classList.add('active');
    
            const userTableRows = users.map((user, index) => `
                <tr data-index="${index}">
                    <td>${user.userId}</td>
                    <td>${user.email}</td>
                    <td>${user.password}</td>
                    <td>
                        <button class="btn btn-custom btn-sm edit-btn">Edit</button>
                        <button class="btn btn-custom btn-sm delete-btn">Delete</button>
                    </td>
                </tr>
            `).join('');

            document.getElementById('main-content').innerHTML = `
                <h2>Users</h2>
                <button id="add-user-btn" class="btn btn-add-user mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">Add User</button>
                <table class="table">
                    <thead>
                        <tr>
                            <th>UserId</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${userTableRows}
                    </tbody>
                </table>
            `;

            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const index = this.closest('tr').dataset.index;
                    const user = users[index];
                    const editFormHtml = `
                        <form id="edit-form" data-index="${index}">
                            <div class="mb-3">
                                <label for="edit-email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="edit-email" value="${user.email}">
                            </div>
                            <div class="mb-3">
                                <label for="edit-password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="edit-password" value="${user.password}">
                            </div>
                            <button type="submit" class="btn btn-custom">Save</button>
                            <button type="button" class="btn btn-secondary" id="cancel-edit">Cancel</button>
                        </form>
                    `;
                    document.getElementById('main-content').innerHTML = editFormHtml;

                    document.getElementById('edit-form').addEventListener('submit', function(e) {
                        e.preventDefault();
                        const index = this.dataset.index;
                        const updatedEmail = document.getElementById('edit-email').value;
                        const updatedPassword = document.getElementById('edit-password').value;
                        const userId = users[index].userId; 
                        location.href = "update_user.php?email="+updatedEmail+"&password="+updatedPassword+"&userId="+userId;


                        
                    });

                    document.getElementById('cancel-edit').addEventListener('click', function() {
                        document.getElementById('user-link').click();
                    });
                });
            });

            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const index = this.closest('tr').dataset.index;
                    const userId = users[index].userId; 

                    location.href = "delete_user.php?userId="+userId;
                    
                });
            });
        });

//  Created by Talha ------------------------------------------------

          // Generatinhg quiz table rows 
    const quizzes = <?php echo json_encode($quizzes); ?>; // $quizzes contains quiz data

        document.getElementById('quiz-link').addEventListener('click', function() {
    // Remove 'active' class from all nav items
    document.querySelectorAll('.nav-link').forEach(link => {
        link.classList.remove('active');
    });

    // Add 'active' class to the clicked nav item
    this.classList.add('active');

  

    const quizTableRows = quizzes.map((quiz, index) => `
        <tr data-index="${index}">
            <td>${quiz.quizId}</td>
            <td>${quiz.quizName}</td>
            <td>${quiz.categoryName}</td>
            <td>
                <button class="btn btn-custom btn-sm edit-btn">Edit</button>
                <button class="btn btn-custom btn-sm delete-btn">Delete</button>
            </td>
        </tr>
    `).join('');

    // Update main content with quiz table
    document.getElementById('main-content').innerHTML = `
        <h2>Quizzes</h2>
        <button id="add-quiz-btn" class="btn btn-add-quiz mb-3" data-bs-toggle="modal" data-bs-target="#addQuizModal">Add Quiz</button>
        <table class="table">
            <thead>
                <tr>
                    <th>Quiz ID</th>
                    <th>Quiz Name</th>
                    <th>Quiz Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                ${quizTableRows}
            </tbody>
        </table>
    `;

    document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const index = this.closest('tr').dataset.index;
                    const quizId = quizzes[index].quizId; 

                    location.href = "delete_quiz.php?quizId="+quizId;
                    
                });
            });


    // Bind edit and delete button events 
   //bindEditDeleteEvents();


});


        // Handle adding a new user
        document.getElementById('add-user-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const name = document.getElementById('add-user-name').value;
            const email = document.getElementById('add-user-email').value;
            const password = document.getElementById('add-user-password').value;

            location.href = "add_user.php?name=" + name+"&email="+email+"&password="+password;
        });

        // Load dashboard content by default
        document.getElementById('dashboard-link').click();
    </script>
</body>
</html>

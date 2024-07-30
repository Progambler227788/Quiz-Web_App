
<!-- Created by Talha -->
<?php
// Database connection settings
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "quizProjectY3";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// drop database if exists
$sqlCreateDatabase = "Drop DATABASE IF EXISTS $database";
if ($conn->query($sqlCreateDatabase) === TRUE) {
    echo "Database 'quizProjectY3' dropped successfully<br>";
} else {
    echo "Error dropping database: " . $conn->error;
}


//Create database
$sqlCreateDatabase = "CREATE DATABASE IF NOT EXISTS $database";
if ($conn->query($sqlCreateDatabase) === TRUE) {
    echo "Database 'quizProjectY3' created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error;
}

// // Select database
$conn->select_db($database);

// Create tables
// User table


$sqlCreateUserTable = "CREATE TABLE IF NOT EXISTS user (
    userId INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
)";
if ($conn->query($sqlCreateUserTable) === TRUE) {
    echo "Table 'user' created successfully<br>";
} else {
    echo "Error creating table 'user': " . $conn->error;
}

// Category table
$sqlCreateCategoryTable = "CREATE TABLE IF NOT EXISTS category (
    categoryId INT AUTO_INCREMENT PRIMARY KEY,
    categoryName VARCHAR(255) NOT NULL
)";
if ($conn->query($sqlCreateCategoryTable) === TRUE) {
    echo "Table 'category' created successfully<br>";
} else {
    echo "Error creating table 'category': " . $conn->error;
}

// Question table
$sqlCreateQuestionTable = "CREATE TABLE IF NOT EXISTS question (
    questionId INT AUTO_INCREMENT PRIMARY KEY,
    questionText TEXT NOT NULL,
    option1 VARCHAR(255) NOT NULL,
    option2 VARCHAR(255) NOT NULL,
    option3 VARCHAR(255) NOT NULL,
    option4 VARCHAR(255) NOT NULL,
    correctAnswer VARCHAR(255) NOT NULL,
    categoryId INT,
    FOREIGN KEY (categoryId) REFERENCES category(categoryId)
)";
if ($conn->query($sqlCreateQuestionTable) === TRUE) {
    echo "Table 'question' created successfully<br>";
} else {
    echo "Error creating table 'question': " . $conn->error;
}

// Quiz table
$sqlCreateQuizTable = "CREATE TABLE IF NOT EXISTS quiz (
    quizId INT AUTO_INCREMENT PRIMARY KEY,
    quizName VARCHAR(255) NOT NULL,
    categoryId INT,
    FOREIGN KEY (categoryId) REFERENCES category(categoryId)
)";
if ($conn->query($sqlCreateQuizTable) === TRUE) {
    echo "Table 'quiz' created successfully<br>";
} else {
    echo "Error creating table 'quiz': " . $conn->error;
}

// QuizQuestion table
$sqlCreateQuizQuestionTable = "CREATE TABLE IF NOT EXISTS quizQuestion (
    quizId INT,
    questionId INT,
    PRIMARY KEY (quizId, questionId),
    FOREIGN KEY (quizId) REFERENCES quiz(quizId),
    FOREIGN KEY (questionId) REFERENCES question(questionId)
)";
if ($conn->query($sqlCreateQuizQuestionTable) === TRUE) {
    echo "Table 'quizQuestion' created successfully<br>";
} else {
    echo "Error creating table 'quizQuestion': " . $conn->error;
}



// Created By Farman

// Leaderboard table
$sqlCreateLeaderboardTable = "CREATE TABLE IF NOT EXISTS leaderboard (
    leaderboardId INT AUTO_INCREMENT PRIMARY KEY,
    userId INT,
    username VARCHAR(255) NOT NULL,
    attemptedTime DATETIME,
    userScore INT,
    userScorePercentage FLOAT,
    FOREIGN KEY (userId) REFERENCES user(userId)
)";
if ($conn->query($sqlCreateLeaderboardTable) === TRUE) {
    echo "Table 'leaderboard' created successfully<br>";
} else {
    echo "Error creating table 'leaderboard': " . $conn->error;
}




// Insert sample data
// Sample categories
$sqlInsertCategories = "INSERT INTO category (categoryName) VALUES
    ('Programming'),
    ('Data Structures'),
    ('Algorithms'),
    ('DLD'),
    ('Assembly')";
if ($conn->query($sqlInsertCategories) === TRUE) {
    echo "Sample categories inserted successfully<br>";
} else {
    echo "Error inserting sample categories: " . $conn->error;
}

// Sample questions
$sqlInsertQuestions = "INSERT INTO question (questionText, option1, option2, option3, option4, correctAnswer, categoryId) VALUES
    -- Programming (Category ID: 1)
    ('What does HTML stand for?', 'Hyper Text Markup Language', 'High Text Markup Language', 'Hyper Tabular Markup Language', 'None of these', 'Hyper Text Markup Language', 1),
    ('What does CSS stand for?', 'Creative Style Sheets', 'Cascading Style Sheets', 'Computer Style Sheets', 'Colorful Style Sheets', 'Cascading Style Sheets', 1),
    ('What does PHP stand for?', 'Hypertext Preprocessor', 'Pretext Hypertext Processor', 'Personal Home Page', 'Private Home Page', 'Hypertext Preprocessor', 1),
    ('Which language is used for web apps?', 'PHP', 'Python', 'JavaScript', 'All of these', 'All of these', 1),
    ('What does SQL stand for?', 'Structured Query Language', 'Stylesheet Query Language', 'Statement Query Language', 'None of these', 'Structured Query Language', 1),
    ('What is the correct HTML element for the largest heading?', '<h1>', '<heading>', '<h6>', '<head>', '<h1>', 1),
    ('Which HTML attribute specifies an alternate text for an image, if the image cannot be displayed?', 'src', 'longdesc', 'alt', 'title', 'alt', 1),
    ('Which property is used to change the background color in CSS?', 'color', 'bgcolor', 'background-color', 'bg-color', 'background-color', 1),
    ('Inside which HTML element do we put the JavaScript?', '<script>', '<javascript>', '<js>', '<scripting>', '<script>', 1),
    ('Which operator is used to assign a value to a variable in JavaScript?', '*', '-', '=', 'x', '=', 1),

    -- Data Structures (Category ID: 2)
    ('Which data structure uses First In First Out (FIFO) principle?', 'Stack', 'Queue', 'Tree', 'Heap', 'Queue', 2),
    ('Which data structure is used for implementing recursion?', 'Stack', 'Queue', 'Linked List', 'Graph', 'Stack', 2),
    ('What is the time complexity of accessing an element in an array?', 'O(1)', 'O(n)', 'O(log n)', 'O(n^2)', 'O(1)', 2),
    ('Which data structure is used to implement priority queues?', 'Stack', 'Queue', 'Heap', 'Linked List', 'Heap', 2),
    ('Which data structure allows insertion and deletion at both ends?', 'Stack', 'Queue', 'Deque', 'Tree', 'Deque', 2),
    ('Which data structure is used in a Breadth First Search (BFS) algorithm?', 'Stack', 'Queue', 'Heap', 'Linked List', 'Queue', 2),
    ('Which of the following data structures is non-linear?', 'Stack', 'Queue', 'Tree', 'Array', 'Tree', 2),
    ('In a linked list, the elements are stored in:', 'Sequential memory locations', 'Non-contiguous memory locations', 'Array', 'None of these', 'Non-contiguous memory locations', 2),
    ('Which of the following operations is the most efficient in a doubly linked list compared to a singly linked list?', 'Insertion at the end', 'Deletion from the end', 'Searching for an element', 'Accessing the middle element', 'Deletion from the end', 2),
    ('In which type of tree does each parent node have at most two children?', 'Binary Tree', 'AVL Tree', 'B-Tree', 'Red-Black Tree', 'Binary Tree', 2),

    -- Algorithms (Category ID: 3)
    ('Which algorithm is used to find the shortest path in a graph?', 'Quick Sort', 'Dijkstra\'s Algorithm', 'Binary Search', 'Merge Sort', 'Dijkstra\'s Algorithm', 3),
    ('Which algorithm is used for sorting in O(n log n) time?', 'Bubble Sort', 'Insertion Sort', 'Merge Sort', 'Selection Sort', 'Merge Sort', 3),
    ('Which algorithm technique is used in binary search?', 'Divide and Conquer', 'Dynamic Programming', 'Greedy Algorithm', 'Backtracking', 'Divide and Conquer', 3),
    ('Which of the following algorithms uses a pivot element to partition the array?', 'Merge Sort', 'Quick Sort', 'Heap Sort', 'Insertion Sort', 'Quick Sort', 3),
    ('Which algorithm is used to detect a cycle in a graph?', 'DFS', 'BFS', 'Dijkstra\'s Algorithm', 'Kruskal\'s Algorithm', 'DFS', 3),
    ('Which of the following algorithms is a Greedy Algorithm?', 'Bubble Sort', 'Kruskal\'s Algorithm', 'Merge Sort', 'Binary Search', 'Kruskal\'s Algorithm', 3),
    ('Which algorithm is used to find the minimum spanning tree in a graph?', 'Quick Sort', 'Prim\'s Algorithm', 'Dijkstra\'s Algorithm', 'Merge Sort', 'Prim\'s Algorithm', 3),
    ('Which of the following is not a stable sorting algorithm?', 'Bubble Sort', 'Quick Sort', 'Merge Sort', 'Insertion Sort', 'Quick Sort', 3),
    ('Which algorithm is used for finding the greatest common divisor (GCD) of two numbers?', 'Euclidean Algorithm', 'Dijkstra\'s Algorithm', 'Quick Sort', 'Binary Search', 'Euclidean Algorithm', 3),
    ('Which algorithm is used to solve the knapsack problem?', 'Greedy Algorithm', 'Dynamic Programming', 'Divide and Conquer', 'Backtracking', 'Dynamic Programming', 3),

    -- Digital Logic Design (DLD) (Category ID: 4)
    ('Which gate is known as the universal gate?', 'AND', 'OR', 'NOT', 'NAND', 'NAND', 4),
    ('What does D in D-flip flop stand for?', 'Delay', 'Data', 'Digital', 'Dynamic', 'Data', 4),
    ('Which of the following is a combinational circuit?', 'Flip Flop', 'Counter', 'Adder', 'Shift Register', 'Adder', 4),
    ('What is the binary equivalent of the decimal number 10?', '1010', '1100', '1001', '1111', '1010', 4),
    ('Which logic gate outputs 1 only when all its inputs are 1?', 'AND', 'OR', 'NOT', 'NAND', 'AND', 4),
    ('Which of the following is a sequential circuit?', 'Multiplexer', 'Demultiplexer', 'Counter', 'Decoder', 'Counter', 4),
    ('What is the primary function of a multiplexer?', 'To convert analog signal to digital signal', 'To route a single input to one of the many outputs', 'To convert digital signal to analog signal', 'To route one of several inputs to a single output', 'To route one of several inputs to a single output', 4),
    ('What does ALU stand for?', 'Arithmetic Logic Unit', 'Application Logic Unit', 'Array Logic Unit', 'None of these', 'Arithmetic Logic Unit', 4),
    ('Which of the following is used for simplification of Boolean expressions?', 'De Morgan\'s Theorems', 'Karnaugh Map', 'Boolean Algebra', 'All of these', 'All of these', 4),
    ('Which flip-flop is used to eliminate race around condition?', 'D Flip-Flop', 'JK Flip-Flop', 'T Flip-Flop', 'SR Flip-Flop', 'JK Flip-Flop', 4),

    -- Assembly (Category ID: 5)
    ('What is the primary purpose of an assembler?', 'To convert assembly code to machine code', 'To convert high-level code to machine code', 'To convert machine code to assembly code', 'To convert assembly code to high-level code', 'To convert assembly code to machine code', 5),
    ('Which of the following registers holds the address of the next instruction to be executed?', 'Instruction Register', 'Program Counter', 'Accumulator', 'Stack Pointer', 'Program Counter', 5),
    ('What does the MOV instruction do in assembly language?', 'Moves data from one location to another', 'Adds two values', 'Subtracts one value from another', 'Compares two values', 'Moves data from one location to another', 5),
    ('Which of the following is a conditional jump instruction?', 'JMP', 'JNZ', 'CALL', 'RET', 'JNZ', 5),
    ('What is the function of the ALU in a CPU?', 'To store data', 'To control input and output operations', 'To perform arithmetic and logical operations', 'To fetch instructions', 'To perform arithmetic and logical operations', 5),
    ('Which directive is used to define a constant value in assembly language?', 'EQU', 'ORG', 'END', 'DB', 'EQU', 5),
    ('Which of the following is not a valid addressing mode in assembly language?', 'Immediate', 'Direct', 'Indirect', 'Random', 'Random', 5),
    ('What is the purpose of the stack in assembly language?', 'To store data temporarily', 'To store the addresses of instructions', 'To store the return addresses of subroutines', 'To store constants', 'To store the return addresses of subroutines', 5),
    ('What is the purpose of the INT instruction in assembly language?', 'To perform an arithmetic operation', 'To call an interrupt service routine', 'To move data from one location to another', 'To compare two values', 'To call an interrupt service routine', 5),
    ('Which register is used to point to the top of the stack?', 'Stack Pointer', 'Base Pointer', 'Program Counter', 'Instruction Register', 'Stack Pointer', 5)";
if ($conn->query($sqlInsertQuestions) === TRUE) {
    echo "Sample questions inserted successfully<br>";
} else {
    echo "Error inserting sample questions: " . $conn->error;
}

// Sample quizzes
$sqlInsertQuizzes = "INSERT INTO quiz (quizName, categoryId) VALUES
    ('General Knowledge Quiz', 1),
    ('Data Structures Quiz', 2),
    ('Algorithms Quiz', 3)";
if ($conn->query($sqlInsertQuizzes) === TRUE) {
    echo "Sample quizzes inserted successfully<br>";
} else {
    echo "Error inserting sample quizzes: " . $conn->error;
}

// Sample quiz questions associations
$sqlInsertQuizQuestions = "INSERT INTO quizQuestion (quizId, questionId) VALUES
    (1, 1),
    (1, 2),
    (2, 2),
    (2, 3),
    (3, 1),
    (3, 3)";
if ($conn->query($sqlInsertQuizQuestions) === TRUE) {
    echo "Sample quiz-question associations inserted successfully<br>";
} else {
    echo "Error inserting sample quiz-question associations: " . $conn->error;
}

// Display sample data
echo "<h2>Sample Data:</h2>";

// Display categories
$sqlSelectCategories = "SELECT * FROM category";
$resultCategories = $conn->query($sqlSelectCategories);
if ($resultCategories->num_rows > 0) {
    echo "<h3>Categories:</h3><ul>";
    while ($row = $resultCategories->fetch_assoc()) {
        echo "<li>{$row['categoryId']}: {$row['categoryName']}</li>";
    }
    echo "</ul>";
} else {
    echo "No categories found";
}

// Display quizzes
$sqlSelectQuizzes = "SELECT * FROM quiz";
$resultQuizzes = $conn->query($sqlSelectQuizzes);
if ($resultQuizzes->num_rows > 0) {
    echo "<h3>Quizzes:</h3><ul>";
    while ($row = $resultQuizzes->fetch_assoc()) {
        echo "<li>{$row['quizId']}: {$row['quizName']} (Category: {$row['categoryId']})</li>";
    }
    echo "</ul>";
} else {
    echo "No quizzes found";
}

// Display questions
$sqlSelectQuestions = "SELECT * FROM question";
$resultQuestions = $conn->query($sqlSelectQuestions);
if ($resultQuestions->num_rows > 0) {
    echo "<h3>Questions:</h3><ul>";
    while ($row = $resultQuestions->fetch_assoc()) {
        echo "<li>{$row['questionId']}: {$row['questionText']} (Category: {$row['categoryId']})</li>";
    }
    echo "</ul>";
} else {
    echo "No questions found";
}


$userCategoryInsertQuery="CREATE TABLE IF NOT EXISTS userCategory (
    userCategoryId int AUTO_INCREMENT PRIMARY KEY,
    userid int ,
    categoryid int,
    FOREIGN KEY (userId) REFERENCES user(userId),
    FOREIGN KEY (categoryId) REFERENCES category(categoryId)
    )";

if ($conn->query($userCategoryInsertQuery) === TRUE) {
            echo "Table 'userCategory' created successfully<br>";
        } else {
            echo "Error creating table 'userCategory': " . $conn->error;
        }

$historyInsertQuery="CREATE TABLE IF NOT EXISTS history(
historyId int AUTO_INCREMENT PRIMARY KEY,
CorrectAnswers int ,
WrongAnswers int,
SuccessRate float,
TotalQuiz int ,
FavoriteCategory VARCHAR(255),
userId int,
FOREIGN KEY (userId) REFERENCES user(userId)
)";


if ($conn->query($historyInsertQuery) === TRUE) {
        echo "Table 'history' created successfully<br>";
    } else {
        echo "Error creating table 'history': " . $conn->error;
    }

//Close connection
$conn->close();
?>

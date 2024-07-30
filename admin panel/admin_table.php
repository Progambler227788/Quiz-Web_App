<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "quizprojecty3";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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


// SQL query to create admin table
$sql_create_table = "CREATE TABLE IF NOT EXISTS admin (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
)";

if ($conn->query($sql_create_table) === TRUE) {
    echo "Admin table created successfully<br>";

    // Sample admin data (you should hash passwords securely in a real application)
    $admin_username = "admin";
    $admin_password = "admin";

   

    // Insert admin data into the admin table
    $sql_insert_admin = "INSERT INTO admin (username, password) VALUES ('$admin_username', '$admin_password')";

    if ($conn->query($sql_insert_admin) === TRUE) {
        echo "Admin added successfully";
    } else {
        echo "Error adding admin: " . $conn->error;
    }
} else {
    echo "Error creating admin table: " . $conn->error;
}

$conn->close();
?>
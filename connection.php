<?php

// Database credentials
$servername = "localhost"; // Your MySQL server address (usually localhost)
$username = "root"; // Your MySQL username (default is 'root' for local development)
$password = ""; // Your MySQL password (default is empty for local development)
$dbname = "user_db"; // The name of your database (change it to match your actual database)

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    // If the connection fails, display an error message and stop the script
    die("Connection failed: " . mysqli_connect_error());
}

// If you reach here, it means the connection was successful
// You can use the $conn variable in other PHP files to query the database

?>

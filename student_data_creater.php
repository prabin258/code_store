<?php
// Establish a database connection
$line = new mysqli("localhost", "root", "");

// Create the "exam" database if it does not exist
$databasequery = "CREATE DATABASE IF NOT EXISTS exam";
$result1 = $line->query($databasequery);

// Select the "exam" database
$line->select_db("exam");

// Create the "students" table if it does not exist
$createstudentsdata = "CREATE TABLE IF NOT EXISTS students(
    firstname VARCHAR(225) NOT NULL,
    surname VARCHAR(225) NOT NULL,
    email VARCHAR(500) NOT NULL UNIQUE,
    token VARCHAR(500) UNIQUE,
    expirytime VARCHAR(500),
    physics_question_response VARCHAR(800),
    chemistry_question_response VARCHAR(800)
)";
$result2 = $line->query($createstudentsdata);

// Check if the form data has been submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize the input data to prevent SQL injection
    $name = sanitizeInput($_POST["name"]);
    $surname = sanitizeInput($_POST["surname"]);
    $email = sanitizeInput($_POST["email"]);

    // Prepare and bind the statement to insert data into the database
    $stmt = $line->prepare("INSERT INTO students (firstname, surname, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $surname, $email);

    // Execute the prepared statement to insert data into the database
    $result3 = $stmt->execute();
}

// Function to sanitize input data
function sanitizeInput($data) {
    global $line;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = $line->real_escape_string($data);
    return $data;
}

// Close the database connection
$line->close();
?>

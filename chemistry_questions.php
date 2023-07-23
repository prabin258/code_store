<?php
// Establish a database connection
$line = new mysqli("localhost", "root", "");

// Create the "exam" database if it does not exist
$databasequery = "CREATE DATABASE IF NOT EXISTS exam";
$result1 = $line->query($databasequery);

// Select the "exam" database
$line->select_db("exam");

// Create the "chemistry_questions" table if it does not exist
$createstudentsdata = "CREATE TABLE IF NOT EXISTS chemistry_questions(
    id INT AUTO_INCREMENT PRIMARY KEY,
    questions VARCHAR(900) NOT NULL,
    option1 VARCHAR(225) NOT NULL,
    option2 VARCHAR(225) NOT NULL,
    option3 VARCHAR(225) NOT NULL,
    option4 VARCHAR(225) NOT NULL,
    correct_option VARCHAR(225) NOT NULL
)";
$result2 = $line->query($createstudentsdata);

// Check if the form data has been submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize the input data to prevent SQL injection
    $questions = sanitizeInput($_POST["question"]);
    $option1 = sanitizeInput($_POST["option1"]);
    $option2 = sanitizeInput($_POST["option2"]);
    $option3 = sanitizeInput($_POST["option3"]);
    $option4 = sanitizeInput($_POST["option4"]);
    $correct_option = sanitizeInput($_POST["correct_option"]);

    // Prepare and bind the statement to insert data into the database
    $stmt = $line->prepare("INSERT INTO chemistry_questions (questions, option1, option2, option3, option4, correct_option) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $questions, $option1, $option2, $option3, $option4, $correct_option);

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

<?php
// Connect to the MySQL server with credentials
$line = new mysqli("localhost", "root", "");

// Create a new database named "exam" if it does not exist
$databasequery = "CREATE DATABASE IF NOT EXISTS exam";
$result1 = $line->query($databasequery);

// Select the "exam" database for further operations
$line->select_db("exam");

// Create a table named "selected_questions" if it does not exist
$createstudentsdata = "CREATE TABLE IF NOT EXISTS selected_questions (
    ID VARCHAR(225) NOT NULL,
    course VARCHAR(60) NOT NULL,
    questions VARCHAR(300) NOT NULL,
    option1 VARCHAR(225) NOT NULL,
    option2 VARCHAR(225) NOT NULL,
    option3 VARCHAR(225) NOT NULL,
    option4 VARCHAR(225) NOT NULL,
    correct_option VARCHAR(225) NOT NULL
)";
$result2 = $line->query($createstudentsdata);

// Close the database connection
$line->close();
?>

<?php
// Establish a database connection
$line = new mysqli("localhost", "root", "");

// Create the "exam" database if it does not exist
$databasequery = "CREATE DATABASE IF NOT EXISTS exam";
$result1 = $line->query($databasequery);

// Check if the database creation was successful
if ($result1) {
    echo ('Successfully created the "exam" database');
} else {
    echo('Failed to create the "exam" database');
}

// Create the "allowed" table if it does not exist
$createstudentsdata = "CREATE TABLE IF NOT EXISTS allowed(
    username VARCHAR(225) NOT NULL UNIQUE,
    pasword VARCHAR(225) NOT NULL
)";
$line->select_db("exam");
$result2 = $line->query($createstudentsdata);

// Check if the table creation was successful
if ($result2) {
    echo ('Successfully created the "allowed" table');
} else {
    echo('Failed to create the "allowed" table');
}

$username = "admin";
$password = md5("root");

// Insert the admin credentials into the "allowed" table
$result3 = $line->query("INSERT INTO allowed (username, pasword) VALUES ('$username','$password')");

// Check if the data insertion was successful
if ($result3) {
    echo 'Successfully inserted data into the "allowed" table';
} else {
    echo 'Failed to insert data into the "allowed" table';
}

// Close the database connection
$line->close();
?>

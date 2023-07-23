<?php
// Connect to the database
$line = new mysqli("localhost", "root", "");
$line->select_db("exam");

$table_selector = "SELECT id FROM selected_questions LIMIT 10 ";
$result = mysqli_query($line, $table_selector);
$rowarray = array();
$idarray = array();

// Retrieve question IDs from the database
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $rowarray[] = $row;
    }

    mysqli_free_result($result);
} else {
    echo "error";
}

$answer_physics = array();
$answer_chemistry = array();

// Store question IDs in an array
foreach ($rowarray as $row) {
    $idarray[] = $row["id"];
}

// Check if the form is submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Loop through each question and process the answers
    foreach ($idarray as $ID) {
        // Check if an answer for the physics question is submitted
        if (isset($_POST["physics" . $ID])) {
            // Store the question ID and its corresponding answer
            $new_answer = $_POST["physics" . $ID];
            $answer_physics[] = $ID;
            $answer_physics[] = $new_answer;
        }
        
        // Check if an answer for the chemistry question is submitted
        if (isset($_POST["chemistry" . $ID])) {
            // Store the question ID and its corresponding answer
            $new_answer = $_POST["chemistry" . $ID];
            $answer_chemistry[] = $ID;
            $answer_chemistry[] = $new_answer;
        }
    }
}

// Convert the arrays of answers into dot-separated strings
$string_physics = implode(".", $answer_physics);
$string_chemistry = implode(".", $answer_chemistry);

// Get the student's email from the POST data
$student_email = $_POST["email"];

// Generate queries to update the "students" table with the question responses
$query_physics = "UPDATE students SET physics_question_response = '$string_physics' WHERE email = '$student_email'";
$query_chemistry = "UPDATE students SET chemistry_question_response = '$string_chemistry' WHERE email = '$student_email'";

// Execute the update queries
$result1 = $line->query($query_physics);
$result2 = $line->query($query_chemistry);

// Close the database connection
$line->close();
?>

<?php
// Connect to the database
$line = new mysqli("localhost", "root", "");
$line->select_db("exam");

// Default expiry time for the questionnaire (in hours)
$expirytime = "1";

// Step 2: Retrieve student data from the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['expirytime'])) {
        $expirytime = $_POST['expirytime'];
    }
}

// Step 3 and 4: Create the "taken_number" table for storing token and expiry date
$tokenTableQuery = "CREATE TABLE IF NOT EXISTS taken_number (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    token VARCHAR(255) NOT NULL,
    expiry_date TIMESTAMP NOT NULL
)";

// Create the table if it doesn't exist
if ($line->query($tokenTableQuery) === TRUE) {
    // Fetch student data from the "students" table
    $studentDataQuery = "SELECT firstname, email FROM students";
    $storer = $line->query($studentDataQuery);

    // Generate token and expiry date for each student and store in "taken_number" table
    while ($row = $storer->fetch_assoc()) {
        $name = $row['firstname'];
        $email = $row['email'];
        $token = bin2hex(random_bytes(16)); // Generate a random token
        $expiryDate = date('Y-m-d H:i:s', strtotime("+$expirytime hours")); // Set the expiry date to current time + specified hours

        $insertTokenQuery = "INSERT INTO taken_number (name, token, expiry_date) VALUES ('$name', '$token', '$expiryDate')";
        $line->query($insertTokenQuery);

        // Step 5: Create unique URL and send it to the student's email
        $url = "http://localhost/test/exam_question_distributer.php?token=" . urlencode($token);
        $subject = "Your exam link";
        $message = "Hello $name,\n\nHere is your link for the exam, please complete the exam within $expirytime hours from now: $url\n\nPlease keep it safe and don't share it with anyone.\n\nBest regards.";
        $headers = "From: enginepal8@gmail.com";

        // Set SMTP settings using ini_set()
        ini_set("SMTP", "smtp.gmail.com");
        ini_set("smtp_port", "587");
        ini_set("sendmail_from", "From: enginepal8@gmail.com");
        ini_set("auth_username", "enginepal8@gmail.com");
        ini_set("auth_password", "ENGInepal8#");

        // Send the email to the student's email address
        mail($email, $subject, $message, $headers);
    }
} else {
    echo "Error creating table: " . $line->error;
}

// Step 6: Select random physics questions and store them in the "selected_questions" table
$table_selector = "SELECT id FROM physics_questions ";
$result = mysqli_query($line, $table_selector);
$rowarray = array();
$idarray = array();

if ($result) {
    // Store physics question IDs in an array
    while ($row = mysqli_fetch_assoc($result)) {
        $rowarray[] = $row;
    }

    mysqli_free_result($result);
} else {
    echo "error";
}

foreach ($rowarray as $row) {
    $idarray[] = $row["id"];
}

// Select a specified number of random physics questions
$numbersofrandoms = 2;
$randomID = array();
$randomIdkey = array_rand($idarray, $numbersofrandoms);

foreach ($randomIdkey as $key) {
    $randomID[] = $idarray[$key];
}

// Store the selected physics questions in the "selected_questions" table
foreach ($randomID as $ID) {
    $transfer = "SELECT * FROM  physics_questions WHERE id='$ID' ";
    $result2 = mysqli_query($line, $transfer);
    $infoarray = mysqli_fetch_assoc($result2);
    $id = $infoarray["id"];
    $course = "physics";
    $questions = $infoarray["questions"];
    $option1 = $infoarray["option1"];
    $option2 = $infoarray["option2"];
    $option3 = $infoarray["option3"];
    $option4 = $infoarray["option4"];
    $correct_option = $infoarray["correct_option"];

    // Insert the selected physics questions into the "selected_questions" table
    $transferquery = $line->query("INSERT INTO selected_questions (ID, course, questions, option1 , option2 , option3, option4 , correct_option) VALUES ('$ID','$course', '$questions', '$option1' , '$option2', '$option3','$option4','$correct_option')");
    if ($transferquery) {
        // Delete the selected physics questions from the "physics_questions" table
        $queryfordelete = $line->query("DELETE FROM physics_questions WHERE id = '$ID'");
    }
}

// Step 7: Select random chemistry questions and store them in the "selected_questions" table
$table_selector2 = "SELECT id FROM chemistry_questions ";
$result3 = mysqli_query($line, $table_selector2);
$rowarray2 = array();
$idarray2 = array();

if ($result3) {
    // Store chemistry question IDs in an array
    while ($row = mysqli_fetch_assoc($result3)) {
        $rowarray2[] = $row;
    }

    mysqli_free_result($result3);
}

foreach ($rowarray2 as $row) {
    $idarray2[] = $row["id"];
}

// Select a specified number of random chemistry questions
$numbersofrandoms2 = 2;
$randomID2 = array();
$randomIdkey2 = array_rand($idarray2, $numbersofrandoms2);

foreach ($randomIdkey2 as $key) {
    $randomID2[] = $idarray2[$key];
}

$course2 = "chemistry";

// Store the selected chemistry questions in the "selected_questions" table
foreach ($randomID2 as $ID) {
    $transfer2 = "SELECT * FROM  chemistry_questions WHERE id='$ID' ";
    $result4 = mysqli_query($line, $transfer2);
    $infoarray2 = mysqli_fetch_assoc($result4);
    $ID2 = $infoarray2["id"];
    $questions2 = $infoarray2["questions"];
    $option12 = $infoarray2["option1"];
    $option22 = $infoarray2["option2"];
    $option32 = $infoarray2["option3"];
    $option42 = $infoarray2["option4"];
    $correct_option2 = $infoarray2["correct_option"];

    // Insert the selected chemistry questions into the "selected_questions" table
    $transferquery2 = $line->query("INSERT INTO selected_questions (ID, course, questions, option1 , option2 , option3, option4 , correct_option) VALUES ('$ID2','$course2', '$questions2', '$option12' ,

    $transferquery2=$line->query("INSERT INTO  selected_questions (ID, course, questions, option1 , option2 , option3,option4 , correct_option) VALUES ('$ID2','$course2', '$questions2', '$option12' , '$option22', '$option32','$option42','$correct_option2')" ) ;
    if ($transferquery2){
    $queryfordelete2 =$line->query( "DELETE FROM chemistry_questions WHERE id = '$ID' ");
    }
}
     echo " <h3> Successfully send the questionnaire to the students and random questions are selected.</h3>";

  // Close the database connection
  $line->close();
  ?>

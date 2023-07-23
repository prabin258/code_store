<!DOCTYPE html>
<html>
<head>
    <title>Questions</title>
    <link rel="stylesheet" type="text/css" href="test.css">
    <script src="test.js" defer></script>
</head>
<body>
    <h1>Physics section</h1>

    <?php
    // Connect to the database
    $line = new mysqli("localhost", "root", "");
    $line->select_db("exam");

    // Check connection
    if ($line->connect_error) {
        die("Connection failed: " . $line->connect_error);
    }

    // Get the token from the URL parameter
    if (isset($_GET["token"])){
        $token = $_GET["token"];

        // Query the "taken_number" table to get the associated expiry date
        $getExpiryQuery = "SELECT expiry_date FROM taken_number WHERE token = '$token'";
        $result1 = $line->query($getExpiryQuery);

        // Check if the token exists and get the expiry date
        if ($result1 && $result1->num_rows > 0) {
            $expiryDate = $result1->fetch_assoc()["expiry_date"];

            // Compare the expiry date with the current date
            $currentDate = date('Y-m-d H:i:s');
            if ($expiryDate < $currentDate) {
                echo "<h3> Your time has been expired, please attempt another exam on time. </h3>";
                die();
            }
        } else {
            echo "<h3> Your token is invalid. Be honest! </h3>";
            die();
        }
    }

    // SQL query to select the first ten rows from the table
    $sql = "SELECT * FROM selected_questions LIMIT 10";

    // Execute the query
    $result = $line->query($sql);
    $value = 0;
    $changer = "physics";

    // Check if the query was successful
    if ($result) {
        // Display a form to submit the answers
        echo '<form action="http://localhost/test/response_record.php" method="post">';
        
        // Loop through the result set and generate input fields for each question
        foreach ($result as $row) {
            $value += 1;
            
            // Switch to Chemistry Section after 5 questions
            if ($value == 6) {
                echo "<h1> Chemistry Section </h1>";
                $changer = "chemistry";
            }
            
            // Retrieve question and options from the database
            $question = $row['questions'];
            $option1 = $row['option1'];
            $option2 = $row['option2'];
            $option3 = $row['option3'];
            $option4 = $row['option4'];

            // Output the question
            echo "<h3 > $value . $question</h3>";

            // Generate radio input fields for options
            echo "<label><input type='radio' name='$changer$row[ID]' value='a'>$option1</label><br>";
            echo "<label><input type='radio' name='$changer$row[ID]' value='b'>$option2</label><br>";
            echo "<label><input type='radio' name='$changer$row[ID]' value='c'>$option3</label><br>";
            echo "<label><input type='radio' name='$changer$row[ID]' value='d'>$option4</label><br><br>";
        }
        
        // Display input fields for first name and email
        $text = "
        <ul> 
        <li> <input type='text' name='firstname' placeholder='first name' required> </li>
        <li> <input type='text' name='email' placeholder='email' required> </li>
        </ul>
        ";
        echo $text;
        
        // Add a submit button to submit the answers
        echo "<button type='submit'>Submit Answers</button>";
        echo "</form>";

        // Free the result set
        $result->free();
    } else {
        // Error executing the query
        echo "Error: " . $line->error;
    }

    // Close the database connection
    $line->close();
    ?>
</body>
</html>

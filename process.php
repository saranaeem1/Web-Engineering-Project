<?php include 'database.php'; ?>
<?php session_start(); ?>

<?php
if (!isset($_SESSION['score'])) {
    $_SESSION['score'] = 0;
}

if ($_POST) {
    $number = $_POST['number'];
    $selected_choice = $_POST['choice'];
    $next = $number + 1;
    $query = "SELECT * FROM quizzes";
    $result = $con->query($query);
    

    $query = "SELECT * FROM quiz WHERE quizID=1 ";
        $results = $con->query($query) or die($con->error . __LINE__);
        $total = $results->num_rows;

        /* get correct choice */
        $query = "SELECT * FROM choices WHERE quesID = $number AND is_correct = 1";

        // get result
        $result = $con->query($query) or die($con->error . __LINE__);

        // get row
        $row = $result->fetch_assoc();
    

        $correct_choice = $row['id'];
        if ($correct_choice == $selected_choice) {
            $_SESSION['score']++;
        }

        if ($number == 10) {
            $score = $_SESSION['score'];
            $progress = 25;
            $quizID = 1;
            // Retrieve the userid from local storage
            $userid = $_SESSION['userid'];

            // Insert the score into the database
            $query = "INSERT INTO result (quizID,score, progress,userid) VALUES ('$quizID','$score', '$progress','$userid')";
            $insert_row = $con->query($query) or die($con->error . __LINE__);

            if ($insert_row) {
                // Score inserted successfully
                echo "score inserted";
                header("Location: final.php");
                exit();
            } else {
                // Error inserting score
                echo "Error inserting score: " . $con->error;
            }

            // Reset the score to zero for the next quiz
            $_SESSION['score'] = 0;
        } 
        else {
            header("Location: question.php?n=" . $next);
        }
    
    
}

?>

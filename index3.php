<?php include "database.php";?>
<?php
   /* get total question of quiz 1*/
   $query="SELECT * FROM quiz where quizID=3";
   $results = $con->query($query) or die($con->error.__LINE__);
   $total= $results->num_rows;
      
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style1.css" type="text/css"></link>
</head>
<body>
<div class="quizimg"><img  src="quiz.jpeg"></div>
        <div class="container-1">

    <main>
    
        <?php
         $query = "SELECT quizname FROM quizzes where quizID=4";
        // Execute the query
        $result = $con->query($query);
        // Check if the query was successful
        if ($result) {
         // Fetch the data and display the names
        while ($row = $result->fetch_assoc()) {
        $name = $row['quizname'];
        echo "<h2>". $name."</h2>";
    }
     } else {
    echo "Error retrieving names: " . $con->error;
}
?> <div class="question">

<ul class="list">
   <li><strong>Number of Question: </strong><?php echo $total ;?></li>
   <li><strong>Type:</strong> MCQS</li>
   <li><strong>Estimated Time: </strong><?php echo $total * .5;?> minutes</li>
</ul>
</div>
<div class="buttons">
   <a href="question3.php?n=31" class="start">Start Quiz</a>
   <a href="final.html" class="cancel">Cancel</a>
</div>
         
    </div>
    </main>
         
</body>
</html>

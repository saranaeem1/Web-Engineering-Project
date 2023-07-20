<?php include 'database.php';?>
<?php session_start();?>
<?php
    /*set question number*/
    $number=(int) $_GET['n'];

     $query = "SELECT quizID FROM quizzes ";
     // Execute the query
     $result = $con->query($query);
             $name = 'quizID';
        

    /*total question */
    $query= "SELECT * FROM quiz ";
       $results=$con->query($query) or die($con->error.__LINE__);
       $total=$results->num_rows;

        /*get question*/
    $query = "SELECT * FROM quiz WHERE  quesID = $number AND quizID = 7 ";
        /*get result*/
    $result = $con->query($query) or die($con->error.__LINE__);
    
    $question = $result->fetch_assoc();

        /*get choices*/
    $query = "SELECT * FROM choices WHERE quesID =$number AND quizID = 7";
        /*get result*/
    $choices = $con->query($query) or die($con->error.__LINE__);
    
       
       if ($number > 70) {
        // Redirect to the next page or display a message
        header("Location: final.php");
        exit();
    }
     

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
    
   <!--<?php echo $question['quesID'];?> of <?php echo $total;?>  -->
    
    <div class="container-1">
    <?php
         $query = "SELECT quizname FROM quizzes where quizID=5";
        // Execute the query
        $result = $con->query($query);
        // Check if the query was successful
        if ($result) {
         // Fetch the data and display the names
        while ($row = $result->fetch_assoc()) {
        $name = $row['quizname'];
        echo "<h2>". $name."</h2>";
    }
}
    ?>
        
        <p class="question">
             <?php echo $question["text"]?>
         </p>
         <form method="post" action="process6.php">
            <ul class="choices">
                <?php while($row = $choices->fetch_assoc()):?>
                    <li><input name="choice" type="radio" value="<?php echo $row['id'];?>"/required><?php echo $row['text'];?></li>
                    
                    
                     
                <?php endwhile; ?>
              </ul>
              <div class="buttons">
              <input class="sub" type="submit" value="Submit"/>
              <a class="cancel" href"final.html">Cancel</a>
              </div>
              
              <input type="hidden" name="number" value="<?php echo $number;?>" />
    </form>
    </div>
 
         
</body>
</html>
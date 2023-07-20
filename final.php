<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style1.css" type="text/css"></link>
</head>
<body>
        <div class="container-1">
            <span><h2>Adobe Illustrator</h2></span>
    
         <p class="attempt"> You're Done</p>
         <p class="attempt2">Congrats! You have completed the test</p>
         <p class="attempt3">Final Score: <?php echo $_SESSION['score'];?></p>
         <?php unset($_SESSION['score']); ?>
         <div class="button1">
         <a href="sidebar.html" class="back">Back</a>
         <a href="progress2.php" class="progress">Progress</a>
        </div>


    </div>
    </main>
         
</body>
</html>
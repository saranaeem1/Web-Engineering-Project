<?php
// Assuming you have established a database connection
$con=mysqli_connect("localhost","root"."");

$db='questionaire';
mysqli_select_db($con,$db);
session_start();

// Retrieve the user's progress from the database
$userProgress = 0; // Set the initial value to 0
// Retrieve the userid from local storage
$userid = $_SESSION['userid'];
$query = "SELECT progress FROM result WHERE userid = '$userid'";
//$query2='SELECT quizID FROM result WHERE userid = '$userid'';

$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $userProgress = $row['progress'];
}
//if (quizID==1 || quizID==2 || quizID==3 || quizID==4)
//{
    //course="Adobe Illustrator";
//}
//else{
   // course="Adobe Photoshop";
//}

// Close the database connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
  <!-- Head section -->
  <style>
    /* Progress bar style */
    .progress-bar-container {
      width: 100%;
      height: 30px;
      background-color: lightgray;
      margin-bottom: 20px;
    }
    
    .progress-bar {
      height: 100%;
      background-color: blue;
      width: <?php echo $userProgress; ?>%;
    }
  </style>
</head>
<body>
  <!-- Body content -->
  <div class="progress-bar-container">
    <div class="progress-bar"></div>
  </div>
  
  
  <?php if ($userProgress >= 50): ?>
    <a href="certificate.html">Download Certificate</a>
  <?php endif; ?>
  
</body>
</html>

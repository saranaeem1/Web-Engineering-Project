<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/e2d8a67779.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="signupLogin.css">
    <title>Document</title>
</head>
<body>
<?php
  // Establish database connection
  $con = mysqli_connect("localhost", "root", "", "questionaire");
  if(!$con) {
      // Display error message if connection fails
      echo "<div class='error-message'>Sorry for the inconvenience</div>";
      die();
  }
  session_start();
  $errors = array();

  if(isset($_POST['submit'])) {
    // Get form data
    $email = $_POST['email'];
    $passwd = $_POST['password'];
    $sql = "SELECT * FROM signup WHERE email = '$email'";
    $result = mysqli_query($con, $sql);
    $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
    if($user) {
      if($passwd == $user['password']) {
        $userid = $user['userid'];
        echo "<script>localStorage.setItem('userId', '$userid');</script>";
        $_SESSION['userid'] = $userid;
        header("location:final.html");
        die();
      } else {
         echo "<div class='error-message'>Incorrect password</div>";
      }
    } else {
      echo "<div class='error-message'>Email does not match</div>";
    }
  }
?>
<div class="container">
    <h2>Login</h2>
    <form action="" method="POST">
      <span><i class="fa-regular fa-envelope"></i></span>
      <input type="email" name="email" placeholder="   Enter your email" required><br>
      <span><i class="fa-solid fa-lock"></i></span>
      <input type="password" name="password" placeholder="   Enter your Password" required>
      <input type="submit" name="submit" value="Login">
      <p>Don't have an account? <a href="#">Signup</a></p>
    </form>
</div>
</body>
</html>
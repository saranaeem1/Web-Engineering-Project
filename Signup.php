<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/e2d8a67779.js" crossorigin="anonymous"></script>
    <title>Document</title>
    <link rel="stylesheet" href="signupLogin.css">
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

    if(isset($_POST['submit'])) {
        // Get form data
        $name = $_POST['username'];
        $email = $_POST['email'];
        $passwd = $_POST['password'];


        // Validate form data
        $errors = array();
        if(empty($name) || empty($email) || empty($passwd)) {
          array_push($errors, "All fields are required");
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          array_push($errors, "Email is not valid");
        }
        if(strlen($passwd) < 8) {
          array_push($errors, "Password must be at least 8 characters long");
        }

        // Check if email already exists
        $checkEmailQuery = "SELECT * FROM signup WHERE email = '$email'";
        $checkEmailResult = mysqli_query($con, $checkEmailQuery);
        if(mysqli_num_rows($checkEmailResult) > 0) {
          array_push($errors, "Email already exists");
        }
        // Display error messages if any error 
        if(count($errors) > 0) {
          foreach ($errors as $error) {
            echo "<div class='error-message'>$error</div>";
          }
          echo "</div>";
        } else {
          // Insert user data into database if there are no errors
          $sql = "INSERT INTO `signup` (name, email, password) VALUES ('$name','$email','$passwd')";
          $result = mysqli_query($con, $sql);
          if($result) {
            echo "<div id='registered-message'>You have been registered</div>";
          } else {
            echo "<div class='error-message'>Registration failed";
            die(mysqli_error($con));
          }
        }
    }
?>

<div class="container">
    <h2>Signup</h2>
    <form action="" method="POST">
        <span><i class="fas fa-user"></i></span>
        <input type="text" name="username" placeholder="Enter your name" required><br>
        <span><i class="far fa-envelope"></i></span>
        <input type="email" name="email" placeholder="Enter your email" required><br>
        <span><i class="fas fa-lock"></i></span>
        <input type="password" name="password" placeholder="Enter your password" required>
        <input type="submit" name="submit" value="Signup">
        <p>Already have an account? <a href="login.php">Login</a></p>
    </form>
</div>
</body>
</html>
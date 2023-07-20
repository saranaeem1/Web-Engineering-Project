<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/e2d8a67779.js" crossorigin="anonymous"></script>
    <title>Feedback Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom, #ffffff, #87ceeb);
            height: 100vh;
        }
        .container {
            max-width: 400px;
            margin: 80px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .container input[type="text"],
        .container input[type="email"],
        .container textarea {
            width: 95%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .container textarea {
            height: 50px;
            resize: vertical;
        }
        .container input[type="submit"] {
            width: 100%;
            padding: 10px;
            background: linear-gradient(0deg, rgba(0, 172, 238, 1) 0%, rgba(2, 126, 251, 1) 100%);
            border: none;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
            font-size: 15px;
            margin-top: 10px;
        }
        .container input[type="submit"]:hover {
            background: linear-gradient(0deg, rgba(0, 3, 255, 1) 0%, rgba(2, 126, 251, 1) 100%);
        }
        .container p {
            font-size: 14px;
            text-align: center;
            padding: 10px;
        }
        #submit-message {
            background-color: #D1E7DD;
            color: #138D75;
            padding: 10px;
            border-radius: 5px;
            margin: 10px auto;
            font-size: 14px;
            width: 300px;
            text-align: center;
        }


    </style>
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
        $feedback = $_POST['feedback'];
        $date=date('Y-m-d');


        // Validate form data
        $errors = array();
        if(empty($name) || empty($email) || empty($feedback)) {
          array_push($errors, "All fields are required");
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          array_push($errors, "Email is not valid");
        }
        if(strlen($feedback)>200) {
          array_push($errors, "Feedback should not be greater than 200 letters");
        }

        // Display error messages if any error 
        if(count($errors) > 0) {
          foreach ($errors as $error) {
            echo "<div class='error-message'>$error</div>";
          }
          echo "</div>";
        } else {
            // Check if the email exists in the signup table
            $checkEmailSql = "SELECT userid FROM signup WHERE email = '$email'";
            $checkEmailResult = mysqli_query($con, $checkEmailSql);

            if (mysqli_num_rows($checkEmailResult) > 0) {
                // Email found, retrieve the user ID
                $row = mysqli_fetch_assoc($checkEmailResult);
                $userId = $row['userid'];
                // Insert user data into database if there are no errors
                $sql = "INSERT INTO `feedback` (userid,message,date) VALUES ('$userId','$feedback','$date')";
                $result = mysqli_query($con, $sql);
                if($result) {
                    echo "<div id='submit-message'>You query has been submitted</div>";
                } else {
                    echo "<div class='error-message'>Failed!";
                    die(mysqli_error($con));
                }
        }
        }
    }
    // Close the database connection.
    mysqli_close($con);
?>

    <div class="container">
        <h2>Feedback Form</h2>
        <form action="" method="POST">
            <input type="text" name="username" placeholder=" Your Name" required>
            <input type="email" name="email" placeholder=" Your Email" required>
            <textarea name="feedback" placeholder=" Your Feedback" required></textarea>
            <input type="submit" name="submit" value="Submit">
        </form>
    </div>
</body>
</html>
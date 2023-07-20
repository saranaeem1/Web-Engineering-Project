<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            background: #ffffff;
        }

        body,
        input,
        textarea,
        a {
            font-family: 'Roboto', sans-serif;
        }

        #container {
            width: 100%;
            padding: 10px;
        }

        .box-wrapper {
            position: relative;
            display: table;
            width: 800px;
            margin: auto;
            margin-top: 35px;
            border-radius: 30px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .contact-info-wrap {
            width: 40%;
            height: 476px;
            padding: 40px;
            float: left;
            display: block;
            border-radius: 30px 0px 0px 30px;
            background: #3498db;
            color: #ffffff;
        }

        .contact-info-title {
            text-align: left;
            font-size: 28px;
            letter-spacing: 0.5px;
        }

        .contact-info-subtitle {
            font-size: 14px;
            font-weight: 300;
            margin-top: 17px;
            letter-spacing: 0.5px;
            line-height: 26px;
        }

        .contact-info-details {
            list-style: none;
            margin: 40px 0px;
        }

        .contact-info-details li {
            margin-top: 20px;
            font-size: 13px;
            color: #3498db;
        }
        .contact-info-details span{
            color: white;
        }

        .contact-info-details li i {
            background: white;
            padding: 10px;
            border-radius: 50%;
            margin-right: 5px;
        }

        .contact-info-details li a {
            color: #ffffff;
            text-decoration: none;
        }

        .contact-info-details li a:hover {
            color: #a8d4f2;
        }

        .social-icons {
            list-style: none;
            text-align: center;
            margin: 20px 0px;
        }

        .social-icons li {
            display: inline-block;
        }

        .social-icons li i {
            background: #ffffff;
            color: #3498db;
            padding: 15px;
            font-size: 15px;
            border-radius: 22%;
            margin: 0px 5px;
            cursor: pointer;
            transition: all .5s;
        }

        .social-icons li i:hover {
            background: #a8d4f2;
            color: #222222;
        }

        .contact-form-wrap {
            width: 60%;
            float: right;
            padding: 40px 25px 35px 25px;
            border-radius: 0px 30px 30px 0px;
            background: #ffffff;
        }

        .contact-form-wrap input[type="text"],
        .contact-form-wrap input[type="email"],
        .contact-form-wrap textarea {
            width: 95%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .contact-form-wrap textarea {
            height: 120px;
            resize: vertical;
        }
        .contact-form-wrap input[type="submit"] {
            width: 95%;
            padding: 10px;
            background: linear-gradient(0deg, rgba(0, 172, 238, 1) 0%, rgba(2, 126, 251, 1) 100%);
            border: none;
            color: #ffffff;
            border-radius: 4px;
            cursor: pointer;
            font-size: 15px;
            margin-top: 10px;
        }
        .contact-form-wrap input[type="submit"]:hover {
            background: linear-gradient(0deg, rgba(0, 3, 255, 1) 0%, rgba(2, 126, 251, 1) 100%);
        }
        .contact-form-wrap h1{
            text-align: center;
            padding:30px 0px;
            font-size:35px;
            color:#3498db;
            letter-spacing: 0.5px;


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
        .error-message {
        background-color: #f8d7da;
        color: #721c24;
        padding: 10px;
        border-radius: 5px;
        margin: 5px auto;
        font-size: 14px;
        width: 300px;
        text-align: center;
    }


        /* Responsive css */

        @media only screen and (max-width: 767px) {
            .box-wrapper {
                width: 100%;
            }

            .contact-info-wrap,
            .contact-form-wrap {
                width: 100%;
                height: inherit;
                float: none;
            }

            .contact-info-wrap {
                border-radius: 30px 30px 0px 0px;
            }

            .contact-form-wrap {
                border-radius: 0px 0px 30px 30px;
            }

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
        $message = $_POST['message'];


        // Validate form data
        $errors = array();
        if(empty($name) || empty($email) || empty($message)) {
          array_push($errors, "All fields are required");
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          array_push($errors, "Email is not valid");
        }
        if(strlen($message)>200) {
          array_push($errors, "It should not be greater than 200 letters");
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
                $sql = "INSERT INTO `help` (userid,message) VALUES ('$userId','$message')";
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

    <section id="container">
        <div class="box-wrapper">
            <div class="contact-info-wrap">
                <h2 class="contact-info-title">Contact Information</h2>
                <h3 class="contact-info-subtitle">Here is the contact information</h3>
                <ul class="contact-info-details">
                    <li>
                        <i class="fas fa-phone-alt"></i>
                        <span>Phone:</span> <a href="tel:+ 1234 5678">+ 1234 5678</a>
                    </li>
                    <li>
                        <i class="fas fa-paper-plane"></i>
                        <span>Email:</span> <a href="mailto:questionaire@gmail.com">questionaire@gmail.com</a>
                    </li>
                    <li>
                        <i class="fas fa-globe"></i>
                        <span>Website:</span> <a href="#">website.com</a>
                    </li>
                </ul>
                <ul class="social-icons">
                    <li><a href="#"><i class="fab fa-facebook"></i></a></li>
                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                </ul>
            </div>
            <div class="contact-form-wrap">
                <h1>Contact Us</h1>
                <form action="" method="POST">
                    <input type="text" name="username" placeholder="Your Name" required>
                    <input type="email" name="email" placeholder="Your Email" required>
                    <textarea name="message" placeholder="Your message" required></textarea>
                    <input type="submit" name="submit" value="Submit">
                </form>
            </div>
        </div>
    </section>
</body>
</html>
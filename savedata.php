<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "questionaire";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve data from the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $fathersName = $_POST['fathersName'];
    $email = $_POST['email'];
    $education = $_POST['education'];
    $gender = $_POST['gender'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $country = $_POST['country'];
    $city = $_POST['city'];
    $internetAvailability = $_POST['internetAvailability'];
    
    // Check if the email exists in the signup table
    $checkEmailSql = "SELECT userid FROM signup WHERE email = '$email'";
    $checkEmailResult = mysqli_query($conn, $checkEmailSql);

    if (mysqli_num_rows($checkEmailResult) > 0) {
        // Email found, retrieve the user ID
        $row = mysqli_fetch_assoc($checkEmailResult);
        $userId = $row['userid'];

        // Insert the data into the database
        $sql = "INSERT INTO users (userid, first_name, last_name, fathers_name, email, education, gender, date_of_birth, country, city, internet_availability)
                VALUES ('$userId', '$firstName', '$lastName', '$fathersName', '$email', '$education', '$gender', '$dateOfBirth', '$country', '$city', '$internetAvailability')";

        if ($conn->query($sql) === TRUE) {
            // Redirect to retrievedata.php after successful submission
            header("Location: retrievedata.php?email=$email");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close the database connection
$conn->close();
?>

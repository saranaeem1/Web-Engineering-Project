<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
    body {
        background-color: lightblue;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    h2 {
        color: white;
        font: 300 normal 2em 'tahoma';
        font-weight: bold;
        text-shadow: 2px 2px #080707, 2px 2px #000000, 3px 2px #0b0b0b;
        text-align: center;

    }

    .profile-table {
        background-color: white;
        border-collapse: collapse;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
        width: 80%;
        max-width: 800px;
    }

    .profile-table th, .profile-table td {
        padding: 10px;
        text-align: left;
    }

    .profile-table th {
        background-color: rgb(121, 211, 249);
        color: white;
    }

    .profile-table tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .profile-table .label-column {
        font-weight: bold;
    }
    </style>
</head>
<body>
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

    $email = $_GET['email'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Display the user's data
        echo "<h2>User Data:</h2>";
        echo "<table class='profile-table'>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td class='label-column'>ID</td><td>" . $row['userid'] . "</td></tr>";
            echo "<tr><td class='label-column'>First Name</td><td>" . $row['first_name'] . "</td></tr>";
            echo "<tr><td class='label-column'>Last Name</td><td>" . $row['last_name'] . "</td></tr>";
            echo "<tr><td class='label-column'>Father's Name</td><td>" . $row['fathers_name'] . "</td></tr>";
            echo "<tr><td class='label-column'>Email</td><td>" . $row['email'] . "</td></tr>";
            echo "<tr><td class='label-column'>Education</td><td>" . $row['education'] . "</td></tr>";
            echo "<tr><td class='label-column'>Gender</td><td>" . $row['gender'] . "</td></tr>";
            echo "<tr><td class='label-column'>Date of Birth</td><td>" . $row['date_of_birth'] . "</td></tr>";
            echo "<tr><td class='label-column'>Country</td><td>" . $row['country'] . "</td></tr>";
            echo "<tr><td class='label-column'>City</td><td>" . $row['city'] . "</td></tr>";
            echo "<tr><td class='label-column'>Internet Availability</td><td>" . $row['internet_availability'] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No data available.";
    }

    // Close the database connection
    $conn->close();
    ?>
</body>
</html>

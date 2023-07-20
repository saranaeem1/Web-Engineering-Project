<?php
$con = mysqli_connect("localhost", "root", "", "questionaire");

session_start();

// Retrieve the user's progress from the database
$userProgress = 0;

// Retrieve the userid from the session
$userid = $_SESSION['userid'];
$userid = mysqli_real_escape_string($con, $userid); 
$query = "SELECT progress, quizID FROM result WHERE userid = '$userid'";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $userProgress = $row['progress'];
  $quizID = $row['quizID'];
}

// Determine the course name based on the quizID
$course = "";

if ($quizID == 1 || $quizID == 2 || $quizID == 3 || $quizID == 4) {
  $course = "Adobe Illustrator";
} else {
  $course = "Adobe Photoshop";
}

// Close the database connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
  <title>My Result</title>
  <style>
    /* Header style */
    .header {
      background-color: lightblue;
      padding: 10px;
      color: white;
      text-align:center;
      font-size: 40px;
      font-weight:bolder;
    }
    .img1 {
      width: 450px;
      height: 350px;
      float: right;
      margin-top: 50px;
      margin-right: 30px;
    }
    
    /* Table style */
    table {
      background-color: white;
      box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
      width: 100%;
      border-collapse: collapse;
      margin-bottom:40px;
    }
    
    table th, table td {
      padding: 10px;
      text-align: left;
      font-size:25px;
      border-bottom: 1px solid lightgray;
    }

    .underline{
    text-decoration: underline;
    margin-top: 2px;
}
/*FORM*/

.Formbox{
    display: flex;
    flex-direction:column;
    margin: 0 auto;
    align-items:center;
    justify-content:center;
    
}
label{
    font-size:22px;
    font-weight: bold;
    margin-right: 7px;
}

input{
    border-color:lightblue;
    height: 25px;
}
.image{
    display: flex;
    flex-direction:row;
    align-items:center;
    justify-content:center;
}
.Formbox button{
    padding:10px;
    color: #0fc1d8;
    background-color:white;
    font-weight: bold;
    border-color:#0fc1d8;
    font-size:15px;
}
.FormHeading{
    font-size:40px;
}

/*CERTIFICATE*/
    .certificate {
      background-color: #000001;
      padding: 20px;
      max-width: 600px;
      margin: 0 auto;
      margin-top: 50px;
      border: 4px solid #00ccff;
      border-radius: 10px;
      overflow-y:hidden;
      position: relative;
    }

    .certificate .top-bar {
      background-color: #050505;
      height: 50px;
      text-align: right;
      padding: 20px;
      color: #ffffff;
      font-weight: bold;
    }

    .certificate .issue-date {
      text-align: right;
      margin-bottom: 20px;
      color: #ffffff;
    }

    .certificate img {
        padding-bottom: 30px;
        margin-top: -190px;
        width:130px;
        height: 80px
    }

    .certificate h1 {
      text-align: center;
      color: #ffffff;
      margin-bottom: 20px;
      text-shadow: 0 0 10px #83eefe, 0 0 20px hsl(176, 64%, 65%), 0 0 30px #61d7e4, 0 0 40px #61c7cf, 0 0 70px #6fd0db, 0 0 80px #77e0eb, 0 0 100px #7cebf8;
    }

    .certificate p {
        margin-top: 20px;
      text-align: center;
      line-height: normal;
      font-size: 18px;
      color: #ffffff;
    }

    .certificate .signature {
    margin-top: 20px;
      bottom: 20px;
      color: #fffdfd;
      font-size: 16px;
      font-style: italic;
    }

    .certificate .signature.left {
      margin-top:  40px;
      margin-bottom: 20px;
      float: left;
      width: 30%;
      color:white;
      text-decoration: underline;
    }

    .certificate .signature.right {
      margin-top:40px;
      margin-bottom: 20px;
      float: right;
      width: 35%;
      color: #fffdfd;
      text-decoration: underline;
    }

    .certificate .footer {
        margin-top:80px;
        background-color: #00ccffc1;
        padding:5px;
        font-weight: bold;
        font-size: 14px;
        color: white;
        text-align: center;
    }
    .home{
    display: inline-block;
    padding: 12px 17px;
    background-color: #0fc1d8;
    color: #fff;
    border: none;
    margin-left:20px;
    text-decoration:none;
    cursor: pointer;
    margin-top: 15px;
    font-size: 14px;
    border-radius: 4px;
    transition: background-color 0.3s;
}
  </style>
</head>
<body>
  <div class="header">My Result</div>
  <table>
    <thead>
      <tr>
        <th>Course</th>
        <th>Progress</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><?php echo $course; ?></td>
        <td><progress id="progress" value="<?php echo $userProgress; ?>" max="100"></progress></td>
        <td><span class="icon icon-status"></span> <span id="status"><?php echo ($userProgress >= 50) ? 'Completed' : 'Incomplete'; ?></span></td>
      </tr>
    </tbody>
  </table>
  
  <?php if ($userProgress >= 50): ?>
    <div class=" Formbox">
    <h1 class="FormHeading">Certificate</h1>
    <form onsubmit="generateCertificate(event)">
      <label for="username">Username:</label>&nbsp;
      <input type="text" id="username" required>
      <br><br>
      <label for="course">Course:</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="text" id="course" required>
      <br><br>
      <button type="submit">Download Certificate</button>
    </form>
    </div>
    
  <?php endif; ?>
  
  <script>
    // Change icon and status
    function changeIconAndStatus() {
      var icon = document.querySelector('.icon-status');
      var statusText = document.getElementById('status');
      
      if (<?php echo $userProgress; ?> >= 50) {
        icon.style.backgroundColor = 'green';
        statusText.textContent = 'Completed';
      } else {
        icon.style.backgroundColor = 'red';
        statusText.textContent = 'Incomplete';
      }
    }
    
    function generateCertificate(event) {
      event.preventDefault();

      // Get the username and course
      const usernameInput = document.getElementById('username');
      const username = usernameInput.value;
      const courseInput = document.getElementById('course');
      const course = courseInput.value;

      // Generate the certificate content (customize as needed)
      const content = `
        <div class="certificate">
          <div class="top-bar">QUESTIONNAIRE</div>
          
          <img src="logocertificate.jpeg" alt="Questionnaire Logo">
          <h1>Certificate of Completion</h1>
          <p>This is to certify that <strong><span class="underline">${username}</span></strong></p>
          <p>has completed the course <strong><span class="underline">${course}</span></strong></p>
          <div class="signature left">Certified</div>
          <div class="signature right">Questionnaire Management</div>
          <div class="issue-date"><b>Issue Date:</b> ${getCurrentDate()}</div>
          <div class="footer">This certificate is issued by the Questionnaire Web Application</div>
        </div>
      `;

      // Convert HTML to PDF
      html2pdf()
        .set({ filename: `${username}_certificate`, margin: [20, 20, 20, 20] })
        .from(content)
        .save();
    }

    function getCurrentDate() {
      const date = new Date();
      const day = date.getDate().toString().padStart(2, '0');
      const month = (date.getMonth() + 1).toString().padStart(2, '0');
      const year = date.getFullYear();
      return `${day}-${month}-${year}`;
    }

    changeIconAndStatus();
  </script>
  <div class="image">
  <img class="img1" title="mastery quiz.gif" src="https://cdn.dribbble.com/users/264588/screenshots/14242850/media/4fdf0ef220bfe6d78e62a0c433303014.gif">
    <img class="img1" src="graph1.png">
  </div>
  <a class="home" href="final.html">Home</a>
</body>
</html>

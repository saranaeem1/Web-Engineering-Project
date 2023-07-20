<!DOCTYPE html>
<html>
<head>
  <title>My Result</title>
  <style>
    /* Header style */
    .header {
      background-color: lightblue;
      padding: 10px;
      color: white;
      font-size: 24px;
    }
    img{
      width:450px;
      height:350px;
      float:right;
      margin-top:50px;
      margin-right:30px;
    }
    
    /* Table style */
    table {
      background-color: white;
      box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
      width: 100%;
      border-collapse: collapse;
    }
    
    table th, table td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid lightgray;
    }
    
    /* Icon styles */
    .icon {
      display: inline-block;
      width: 20px;
      height: 20px;
      background-color: gray;
      border-radius: 50%;
    }
    
    .icon-course {
      background-color: blue;
    }
    
    .icon-completion {
      background-color: green;
    }
    
    .icon-status {
      background-color: orange;
    }
    
    /* Graph styles */
    .graph {
      margin-top: 20px;
      width: 100%;
      height: 200px;
      background-color: lightgray;
      display: flex;
      align-items: flex-end;
    }
    
    .bar {
      flex-grow: 1;
      background-color: blue;
      transition: height 0.5s;
    }
  </style>
</head>
<body>
  <div class="header">My Result</div>
  <table>
    <thead>
      <tr>
        <th>Course</th>
        <th>Completion Criteria</th>
        <th>Progress</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><span class="icon icon-course"></span> <span id="course-name"></span></td>
        <td id="completion-cell"><span class="icon icon-completion"></span> Completion Criteria</td>
        <td><progress id="progress" value="50" max="100"></progress></td>
        <td><span class="icon icon-status"></span> <span id="status">Completed</span></td>
      </tr>
    </tbody>
  </table>
  
  <div class="graph" id="graph"></div>
  
  <script>
    // Display course name
    function displayCourseName(courseId) {
      
    }

    var courseId = 'your-course-id';
    document.getElementById("course-name").innerHTML = displayCourseName(courseId);
    
    // Change icon and status
    function changeIconAndStatus() {
      var icon = document.querySelector('.icon-status');
      var statusText = document.getElementById('status');
      
      if (/* Your condition to determine completion */) {
        icon.style.backgroundColor = 'green';
        statusText.textContent = 'Completed';
      } else {
        icon.style.backgroundColor = 'red';
        statusText.textContent = 'Incomplete';
      }
    }
    changeIconAndStatus();
    
    // Update completion criteria
    function updateCompletionCriteria(criteria) {
      var completionCell = document.getElementById('completion-cell');
      completionCell.textContent = criteria;
    }
    var completionCriteria = 'Your completion criteria';
    updateCompletionCriteria(completionCriteria);
    
    // Function to create a bar graph
    function createGraph(scores) {
      var graphContainer = document.getElementById('graph');
      
      // Clear existing bars
      while (graphContainer.firstChild) {
        graphContainer.firstChild.remove();
      }
      
      // Create bars based on scores
      for (var i = 0; i < scores.length; i++) {
        var score = scores[i];
        
        var bar = document.createElement('div');
        bar.className = 'bar';
        bar.style.height = score + '%';
        
        graphContainer.appendChild(bar);
      }
    }
    
    // Example usage of createGraph function
    var scores = [80, 90, 75, 60, 85]; // Example scores
    createGraph(scores);
  </script>
  <img title="mastery quiz.gif" src="https://cdn.dribbble.com/users/264588/screenshots/14242850/media/4fdf0ef220bfe6d78e62a0c433303014.gif">
</body>
</html>

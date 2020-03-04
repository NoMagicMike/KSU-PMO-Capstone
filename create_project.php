<?php
//include the pmo_functions.php file to add header, footer, and navbar
include 'pmo_functions.php';
//make a connection to the database for these specific tasks
$conn = pdo_connect_mysql();
  //make sure post data is not empty
  if (!empty($_POST)) {
  // Check if POST variables were filled with input values, if not default the values to blank
  $title = isset($_POST["project_title"]) ? $_POST["project_title"] : '';
  $dep = isset($_POST["department"]) ? $_POST["department"] : '';
  $start = isset($_POST["start_date"]) ? $_POST["start_date"] : '';
  $end = isset($_POST["end_date"]) ? $_POST["end_date"] : '';
  $priority = isset($_POST["priority_level"]) ? $_POST["priority_level"] : '';
  $fund = isset($_POST["funded"]) ? $_POST["funded"] : '';
  $cost = isset($_POST["total_cost"]) ? $_POST["total_cost"] : '';
  $des = isset($_POST["project_description"]) ? $_POST["project_description"] : '';
  // prepared sql statements to insert new record into project table
  $stmt = $conn->prepare('INSERT INTO project (project_title, department,
	start_date, end_date, priority_level, funded, total_cost, project_description) VALUES(?, ?, ?, ?, ?, ?, ?, ?)');
  $stmt->execute([$title, $dep, $start, $end, $priority, $fund, $cost, $des]);
  //message so the user can acknowledge an alert that the record was added.
  //URL in javascript below will need to be changed to one tht will work with the actual server!
	echo "<script type='text/JavaScript'>
        window.location.href = '/get_project.php';
	      alert('Record Successfully Added.');
	      </script>";
  }
?>
<!--Add in header from pmo_functions.php and insert the title of this page, "Create Project"-->
<?=template_header('Create Project')?>
<!--Start of container for Create Project section-->
<div class="container">
	<h2>Create Project</h2>
    <!--Link this form's actions to this file, create_project.php-->
    <form action="create_project.php" autocomplete="off" method="post">
        <label for="project_title">Project Title :</label>
        <input type="text" id="project_title" name="project_title" placeholder="ex./ PMO Capstone" required>
        <br />
        <label for="department">Department :</label>
        <select id="department" name="department" required>
        <option value="" disabled selected>Select a Department</option>
        <option value="Analytics and Data Science">Analytics and Data Science</option>
        <option value="Computer Science">Computer Science</option>
        <option value="Information Technology">Information Technology</option>
        <option value="Software Engineering and Game Development">Software Engineering and Game Development</option>
        </select>
        <br />
        <label for="start_date">Start Date :</label>
        <input type="date" id="start_date" name="start_date" placeholder="Format: YYYY-MM-DD">
        <br />
        <label for="end_date">End Date :</label>
        <input type="date" id="end_date" name="end_date" placeholder="Format: YYYY-MM-DD">
        <br />
        <label for="priority_level">Priority Level :</label>
        <select required id="priority_level" name="priority_level" required>
        <option value="" disabled selected>Select a Priority Level</option>
        <option value="Low">Low</option>
        <option value="Medium">Medium</option>
        <option value="High">High</option>
        </select>
        <br />
        <label for="funded">Is this project funded ?</label>
        <input type="radio" id="yes" name="funded" value="Yes"> Yes
        <input type="radio" id="no" name="funded" value="No"> No
        <input type="radio" id="n/a" name="funded" value="N/A" checked> N/A
        <br />
        <label for="total_cost">Total Cost : $</label>
        <input type="text" id="total_cost" name="total_cost" placeholder="Format: 0.00">
        <br />
        <label for="project_description">Description :</label>
        <input type="text" id="project_description" maxlength="600" name="project_description" placeholder="Type up to 600 characters.">
        <br />
        <input type="submit" id="submit_btn" value="Submit">
        <br />
    </form>
</div>
<!--end of create project section container-->
<!--Add in footer from pmo_functions.php-->
<?=template_footer()?>

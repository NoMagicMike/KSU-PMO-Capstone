<?php
//include the pmo_functions.php file to add header, footer, and navbar
include 'pmo_functions.php';
//make a connection to the database for these specific tasks
$conn = pdo_connect_mysql();
// Check if the project_id exists
if (isset($_GET['project_id'])) {
    //make sure post data is not empty
    if (!empty($_POST)) {
        // This part is similar to the create_project.php, but instead we update a record instead of creating one
        $title = isset($_POST["project_title"]) ? $_POST["project_title"] : '';
        $dep = isset($_POST["department"]) ? $_POST["department"] : '';
        $start = isset($_POST["start_date"]) ? $_POST["start_date"] : '';
        $end = isset($_POST["end_date"]) ? $_POST["end_date"] : '';
        $priority = isset($_POST["priority_level"]) ? $_POST["priority_level"] : '';
        $fund = isset($_POST["funded"]) ? $_POST["funded"] : '';
        $cost = isset($_POST["total_cost"]) ? $_POST["total_cost"] : '';
        $des = isset($_POST["project_description"]) ? $_POST["project_description"] : '';
        // Update the record with prepared sql
        $stmt = $conn->prepare('UPDATE projects SET project_title = ?, department = ?, start_date = ?, end_date = ?,
          priority_level = ?, funded = ?, total_cost = ?, project_description = ? WHERE project_id = ?');
        $stmt->execute([$title, $dep, $start, $end, $priority, $fund, $cost, $des, $_GET['project_id']]);
        //javascript to pop up a message so the user can acknowledge an alert that the record was updated.
        //URL below will need to be changed to one tht will work with the actual server!
      	echo "<script type='text/JavaScript'>
              window.location.href = 'http://localhost:8015/get_project.php';
      	      alert('Record Successfully Updated.');
      	      </script>";
    }
    // Get the specified project from the projects table
    $stmt = $conn->prepare('SELECT * FROM projects WHERE project_id = ?');
    $stmt->execute([$_GET['project_id']]);
    $project = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$project) {
        die ('Project doesn\'t exist with that ID!');
    }
} else {
    die ('No ID specified!');
}
?>
<!--Add in header from pmo_functions.php and insert the title of this page, "Update Project"-->
<?=template_header('Update Project')?>
<!--Start of container for Update Project section-->
<div class="container">
  <!--In the heading, pull up the ID number and Title of the project selected for updating-->
	<h2>Update Project #<?=$project['project_id']?> - <?=$project['project_title']?></h2>
    <!--Link this form's actions to this file, update_project.php-->
    <form action="update_project.php?project_id=<?=$project['project_id']?>" method="post">
        <label for="project_title">Project Title :</label>
        <input type="text" name="project_title" placeholder="ex./ PMO Capstone" value="<?=$project['project_title']?>" id="project_title">
        <br />
        <label for="department">Department :</label>
        <select id="department" name="department" required>
        <option value="" disabled selected>Select a Department</option>
        <option <?php if($project['department']=="Analytics and Data Science"){echo "selected";}?>>Analytics and Data Science</option>
        <option <?php if($project['department']=="Computer Science"){echo "selected";}?>>Computer Science</option>
        <option <?php if($project['department']=="Information Technology"){echo "selected";}?>>Information Technology</option>
        <option <?php if($project['department']=="Software Engineering and Game Development"){echo "selected";}?>>Software Engineering and Game Development</option>
        </select>
        <br />
        <label for="start_date">Start Date :</label>
        <input type="date" name="start_date" placeholder="Format: YYYY-MM-DD" value="<?=$project['start_date']?>" id="start_date">
        <br />
        <label for="end_date">End Date :</label>
        <input type="date" name="end_date" placeholder="Format: YYYY-MM-DD" value="<?=$project['end_date']?>" id="end_date">
        <br />
        <label for="priority_level">Priority Level :</label>
        <select id="priority_level" name="priority_level" required>
        <option value="" disabled selected>Select a Priority Level :</option>
        <option <?php if($project['priority_level']=="Low"){echo "selected";}?>>Low</option>
        <option <?php if($project['priority_level']=="Medium"){echo "selected";}?>>Medium</option>
        <option <?php if($project['priority_level']=="High"){echo "selected";}?>>High</option>
        </select>
        <br />
        <label for="funded">Is this project funded ?</label>
        <input id="yes" type="radio" name="funded" value="yes" <?php if ($project['funded']=='yes') echo 'checked="checked"'; ?> /> Yes
        <input id="no" type="radio" name="funded" value="no" <?php if ($project['funded']=='no') echo 'checked="checked"'; ?> /> No
        <input id="n/a" type="radio" name="funded" value="n/a" <?php if ($project['funded']== 'n/a') echo 'checked="checked"'; ?> /> N/A
        <br />
        <label for="total_cost">Total Cost : $</label>
        <input type="text" name="total_cost" placeholder="Format: 0.00" value="<?=$project['total_cost']?>" id="total_cost">
        <br />
        <label for="project_description">Description :</label>
        <input type="text" id="project_description" name="project_description" maxlength="600" placeholder="Type up to 600 characters." value="<?=$project['project_description']?>" id="project_description">
        <br />
        <input type="submit" value="Update">
        <br />
    </form>
</div>
<!--end of update project section container-->
<!--Add in footer from pmo_functions.php-->
<?=template_footer()?>

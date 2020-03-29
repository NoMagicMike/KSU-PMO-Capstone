<?php
// Initialize the session
session_start();
//include the pmo_functions.php file to add header, footer, and navbar
require 'pmo_functions.php';
//make a connection to the database for these specific tasks
$conn = pdo_connect_mysql();
// Check that the project ID exists
if (isset($_GET['project_id'])) {
    // Select the record that is going to be deleted
    $stmt = $conn->prepare('SELECT * FROM project WHERE project_id = ?');
    $stmt->execute([$_GET['project_id']]);
    $project = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$project) {
        die ('Project doesn\'t exist with that ID!');
    }
    // Let the user confirm that they want to delete the record
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // If the user clicks the "Yes" button, delete the record
            $stmt = $conn->prepare('DELETE FROM project WHERE project_id = ?');
            $stmt->execute([$_GET['project_id']]);
            //message so the user can acknowledge an alert that the record was deleted.
            //the javascript below will need to be changed to the URL that will work on the actual server!
            echo "<script type='text/JavaScript'>
                  window.location.href = '/get_project.php';
	                alert('Record was Deleted!');
	                </script>";
        } else {
            // If the user clicked the "No" button, redirect them back to the get_project.php page
            header('Location: get_project.php');
            exit;
        }
    }
} else {
    die ('No ID specified!');
}
?>
<!--Add in header from pmo_functions.php and insert the title of this page, "Delete Project"-->
<?=template_header('Delete Project')?>
<!--Beginning of container for delete project section-->
<div>
  <!--pull up the project ID and Title as part of the heading-->
	<h2>Delete Project #<?=$project['project_id']?> - <?=$project['project_title']?></h2>
	<p>Are you sure you want to delete this project?</p>
    <!--Beginning of container for confirmation links yes or no-->
    <div>
        <a href="delete_project.php?project_id=<?=$project['project_id']?>&confirm=yes">Yes</a>
        <a href="delete_project.php?project_id=<?=$project['project_id']?>&confirm=no">No</a>
    </div>
    <!--End of container for confirmation links yes or no-->
</div>
<!--End of container for delete project section-->
<!--Add in footer from pmo_functions.php-->
<?=template_footer()?>

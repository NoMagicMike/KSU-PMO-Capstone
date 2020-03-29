<?php
// Initialize the session
session_start();
//include the pmo_functions.php file to add header, footer, and navbar
require 'pmo_functions.php';
include 'navbar.php';
//make a connection to the database for these specific tasks
$conn = pdo_connect_mysql();
// Check that the user ID exists
if (isset($_GET['user_id'])) {
    // Select the record that is going to be deleted
    $stmt = $conn->prepare('SELECT * FROM user WHERE user_id = ?');
    $stmt->execute([$_GET['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        die ('User doesn\'t exist with that ID!');
    }
    // Let the user confirm that they want to delete the record
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // If the user clicks the "Yes" button, delete the record
            $stmt = $conn->prepare('DELETE FROM user WHERE user_id = ?');
            $stmt->execute([$_GET['user_id']]);
            //message so the user can acknowledge an alert that the record was deleted.
            //the javascript below will need to be changed to the URL that will work on the actual server!
            echo "<script type='text/JavaScript'>
                  window.location.href = '/get_user.php';
	                alert('Record was Deleted!');
	                </script>";
        } else {
            // If the user clicked the "No" button, redirect them back to the get_user.php page
            header('Location: get_user.php');
            exit;
        }
    }
} else {
    die ('No ID specified!');
}
?>
<!--Add in header from pmo_functions.php and insert the title of this page, "Delete User"-->
<?=template_header('Delete User')?>
<!--Beginning of container for delete user section-->
<div>
  <!--pull up the user ID and Title as part of the heading-->
	<h2>Delete User <?=$user['username']?></h2>
	<p>Are you sure you want to delete this user?</p>
    <!--Beginning of container for confirmation links yes or no-->
    <div>
        <a href="delete_user.php?user_id=<?=$user['user_id']?>&confirm=yes">Yes</a>
        <a href="delete_user.php?user_id=<?=$user['user_id']?>&confirm=no">No</a>
    </div>
    <!--End of container for confirmation links yes or no-->
</div>
<!--End of container for delete user section-->
<!--Add in footer from pmo_functions.php-->
<?=template_footer()?>

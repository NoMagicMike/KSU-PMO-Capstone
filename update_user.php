<?php
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
//Check if user is admin
if($_SESSION['adminCheck'] != 1){
  echo "<script type='text/JavaScript'>
        window.location.href = '/index.php';
	      alert('You are not an administrative user.');
	      </script>";
  exit;
}
//include the pmo_functions.php file to add header, footer, and navbar
require 'pmo_functions.php';
//make a connection to the database for these specific tasks
$conn = pdo_connect_mysql();
// Define variables and initialize with empty values
$result = $user_admin = "";
// Check if the user_id exists
if (isset($_GET['user_id'])) {
    //make sure post data is not empty
    if (!empty($_POST)) {
        // This part is similar to the create_user.php, but instead we update a record instead of creating one
        $username = isset($_POST["username"]) ? $_POST["username"] : '';
        if (isset($_POST["user_adminBox"])){
          $user_admin = (int)$_POST["user_adminBox"];
        }
        else {
          $user_admin = 0;
        } 
        // Update the record with prepared sql
        $stmt = $conn->prepare('UPDATE user SET username = ?, user_admin = ? WHERE user_id = ?');
        $stmt->execute([$username,$user_admin, $_GET['user_id']]);
        
        //javascript to pop up a message so the user can acknowledge an alert that the record was updated.
        //Bootstrap Success Alert
      	$result = '<div class="alert alert-success"><strong>Success!</strong> User Updated. <a href="get_user.php" class="alert-link">View All Users</a>.</div>';
    }
    // Get the specified user from the user table
    $stmt = $conn->prepare('SELECT * FROM user WHERE user_id = ?');
    $stmt->execute([$_GET['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        die ('User doesn\'t exist with that ID!');
    }
} else {
    die ('No ID specified!');
}
?>
<!--Add in header from pmo_functions.php and insert the title of this page, "Update User"-->
<?=template_header('Update User')?>
<!--Start of container for Update User section-->
<div class="container">
  <?php echo $result; ?>
  <!--In the heading, pull up the ID number and username of the user selected for updating-->
	<h2>Update User #<?=$user['user_id']?> - <?=$user['username']?></h2>
    <!--Link this form's actions to this file, update_user.php-->
    <form action="update_user.php?user_id=<?=$user['user_id']?>" method="post">
        <label for="username">Username :</label>
        <input type="text" name="username" value="<?=$user['username']?>" id="username">
        <br />
        <label>Allow Admin Priveledges?</label>
        <input type="checkbox" name="user_adminBox" value="1">
        </div>
        <br />
        <input type="submit" value="Update">
        <br />
    </form>
</div>
<!--end of update user section container-->
<!--Add in footer from pmo_functions.php-->
<?=template_footer()?>

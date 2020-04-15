<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
//include the pmo_functions.php file and navbar.php to add header, footer, and navbar
include 'pmo_functions.php';
include 'navbar.php';
// Additional PHP code can go here if needed.
?>
<!--Add in header from pmo_functions.php and insert the title of this page, "Home"-->

<!--Beginning of container for jumbotron-->
<div class="jumbotron">
	<h1 class="display-4">Kennesaw State University</h1>
	<p class="lead">Project Management System</p>
	<hr class="my-4">
	<p>Please use the navigation bar above to view options, or hit the button below to create a new project.</p>
	<a class="btn btn-primary btn-lg" href="create_project.php" role="button">New Project</a>
</div>
<!--End of container for jumbotron-->
<!--Add in footer from pmo_functions.php-->
<?=template_footer()?>

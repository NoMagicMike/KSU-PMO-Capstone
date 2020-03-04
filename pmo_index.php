<?php
//include the pmo_functions.php file to add header, footer, and navbar
include 'pmo_functions.php';
// Additional PHP code can go here if needed.
?>
<!--Add in header from pmo_functions.php and insert the title of this page, "Home"-->
<?=template_header('Home')?>
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

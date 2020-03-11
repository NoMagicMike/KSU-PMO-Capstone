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
// Check if the user is an admin
// $_SESSION["secretword"] = "ABC123" ;
$secretword = $_SESSION["secretword"];
echo "$secretword";

?>
<!--Beginning of container for jumbotron-->

<div class="jumbotron">
	<?php var_dump ($_SESSION) ?>
</div>
<!--End of container for jumbotron-->
<!--Add in footer from pmo_functions.php-->
<?=template_footer()?>

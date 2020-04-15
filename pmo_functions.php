<?php
/*This file will be included in every other file for this project except any .css or .scss files*/
include 'navbar.php';

// This DB Connection is for the Log In. 
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'pmo');
    /*------ For Development Server Only!-----*/
    // define('DB_SERVER', 'localhost');
    // define('DB_USERNAME', 'KSUPMO');
    // define('DB_PASSWORD', 'KSU_Capstone_2020');
    // define('DB_NAME', 'pmo');
    
 
/* Attempt to connect to MySQL database */
try{
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}
/*-----------start of function to connect to pmo database-----------------*/
function pdo_connect_mysql() {
 /*------ For Development Server Only!-----*/
 // $servername = "localhost";
 // $username = "KSUPMO";
 // $password = "KSU_Capstone_2020";
 // $dbname = "pmo";
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'pmo';
//try the following code
try {
    	return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
      // Set the PDO error mode to report errors and throw exceptions
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      //catch errors or exceptions
    } catch (PDOException $exception) {
    	// If there is an error with the connection, stop the script and display the error.
    	die ('Failed to connect to database!'. $exception->getMessage());
    }
}
/*---------------end of function to connect to pmo database--------------------------*/

/*----------------start of function for making the header of each page---------------*/
//This function contains the opening html tag, the head, the opening body tag, and the navbar for every page
function template_header($title) {
echo <<<EOT
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>$title</title>
    <!-- fontawesome is used for the icons-->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <!-- Bootstrap References -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <!--link all the pages to the external styling css file, pmo_style.css-->
		<link href="pmo_style.css" rel="stylesheet" type="text/css">
    </head>
	<body>
  

EOT;
}
/*-----------end of function for making the header for every page----------------*/

/*-----------start of function for making the footer for every page--------------*/
//This function contains the closing body tag, and the closing html tag
function template_footer() {
  // For Dev Use Only
  // var_dump($_SESSION);
  //include 'footer.php';
}
/*-----------end of function for making the footer of each page-------*/
?>

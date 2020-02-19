<?php
// For Development Server Only!
// $servername = "localhost";
// $username = "KSUPMO";
// $password = "KSU_Capstone_2020";
// $dbname = "pmo";

//Set php variables for connections to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pmo";

//try the following code..
try {

	//make a connection to the database
	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

	// set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // prepared sql statements to send input to Projects database table, and bind the parameters to php variables
  $stmt = $conn->prepare("INSERT INTO projects (project_title, department,
	start_date, end_date, priority_level, funded, total_cost, project_description)
  VALUES (:p_title, :dept, :s_date, :e_date, :pri_lvl, :fund, :t_cost, :des)");
  $stmt->bindParam(':p_title', $title);
	$stmt->bindParam(':dept', $dep);
	$stmt->bindParam(':s_date', $start);
	$stmt->bindParam(':e_date', $end);
	$stmt->bindParam(':pri_lvl', $priority);
	$stmt->bindParam(':fund', $fnd);
  $stmt->bindParam(':t_cost', $cost);
	$stmt->bindParam(':des', $des);


	/*Set php variables to hold and insert user input into a MySQL table row,
	by using 'names' of input from html add_project_form.html */
    $title = $_POST["proj_title"];
	$dep = $_POST["dept"];
	$start = $_POST["st_date"];
	$end = $_POST["en_date"];
	$priority = $_POST["p_level"];
	$fnd = $_POST["is_funded"];
  $cost = $_POST["tot_cost"];
	$des = $_POST["desc"];
    $stmt->execute();

    //Re-direct user back to the add_project_form.html page after acknowledging that new records were added.
	echo "<script type='text/JavaScript'>
          window.location.href = 'http://localhost:8015/add_project_form.html';
	      alert('New Records added.');
	      </script>";
	}//<--End of try block

//Now start the catch block to catch any exception that may get thrown and show the error
    catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }

//end connection with database
$conn = null;

?>

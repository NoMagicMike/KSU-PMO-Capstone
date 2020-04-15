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

  //make sure post data is not empty
  if (!empty($_POST)) {
		// Check if POST variables were filled with input values, if not default the values to blank
		$category = isset($_POST["project_category"]) ? $_POST["project_category"] : '';
		$organization = isset($_POST["organization_name"]) ? $_POST["organization_name"] : '';
		$title = isset($_POST["project_title"]) ? $_POST["project_title"] : '';
		$dep = isset($_POST["ksu_department"]) ? $_POST["ksu_department"] : '';
		$priority = isset($_POST["priority_level"]) ? $_POST["priority_level"] : '';
		$start = isset($_POST["start_date"]) ? $_POST["start_date"] : '';
		$end = isset($_POST["end_date"]) ? $_POST["end_date"] : '';
		$fund = isset($_POST["funded"]) ? $_POST["funded"] : '';
		$cost = isset($_POST["total_cost"]) ? $_POST["total_cost"] : '';
		$desc = isset($_POST["description"]) ? $_POST["description"] : '';
		$approval = isset($_POST["approval"]) ? $_POST["approval"] : '';
    //variables that are used to store input for the Sponsor
    $sp_cat = "Sponsor";
    $sp_last = isset($_POST["last_name"]) ? $_POST["last_name"] : '';
    $sp_first = isset($_POST["first_name"]) ? $_POST["first_name"] : '';
    $sp_org = isset($_POST["participant_org"]) ? $_POST["participant_org"] : '';
    $sp_email = isset($_POST["email"]) ? $_POST["email"] : '';
    $sp_phone = isset($_POST["phone"]) ? $_POST["phone"] : '';
    //variables used to store input for Faculty
    $f_cat = "Faculty";
    $f_last = isset($_POST["f_lname"]) ? $_POST["f_lname"] : '';
    $f_first = isset($_POST["f_fname"]) ? $_POST["f_fname"] : '';
    $f_org = isset($_POST["f_org"]) ? $_POST["f_org"] : '';
    $f_email = isset($_POST["f_email"]) ? $_POST["f_email"] : '';
    $f_phone = isset($_POST["f_phone"]) ? $_POST["f_phone"] : '';
    $f_dept = isset($_POST["f_dept"]) ? $_POST["f_dept"] : '';
    $f_title = isset($_POST["f_title"]) ? $_POST["f_title"] : '';
    //variables used to store input for Staff
    $sta_cat = "Staff";
    $sta_last = isset($_POST["sta_lname"]) ? $_POST["sta_lname"] : '';
    $sta_first = isset($_POST["sta_fname"]) ? $_POST["sta_fname"] : '';
    $sta_org = isset($_POST["sta_org"]) ? $_POST["sta_org"] : '';
    $sta_email = isset($_POST["sta_email"]) ? $_POST["sta_email"] : '';
    $sta_phone = isset($_POST["sta_phone"]) ? $_POST["sta_phone"] : '';
    $sta_dept = isset($_POST["sta_dept"]) ? $_POST["sta_dept"] : '';
    $sta_title = isset($_POST["sta_title"]) ? $_POST["sta_title"] : '';
    //variables used to store input for Student
    $stu_cat = "Student";
    $stu_last = isset($_POST["stu_lname"]) ? $_POST["stu_lname"] : '';
    $stu_first = isset($_POST["stu_fname"]) ? $_POST["stu_fname"] : '';
    $stu_org = isset($_POST["stu_org"]) ? $_POST["stu_org"] : '';
    $stu_email = isset($_POST["stu_email"]) ? $_POST["stu_email"] : '';
    $stu_phone = isset($_POST["stu_phone"]) ? $_POST["stu_phone"] : '';
    $major = isset($_POST["major"]) ? $_POST["major"] : '';
    $stu_lvl = isset($_POST["stu_lvl"]) ? $_POST["stu_lvl"] : '';
    //variables used to store input for Contractors
    $c_cat = "Contractor";
    $c_last = isset($_POST["c_lname"]) ? $_POST["c_lname"] : '';
    $c_first = isset($_POST["c_fname"]) ? $_POST["c_fname"] : '';
    $c_org = isset($_POST["c_org"]) ? $_POST["c_org"] : '';
    $c_email = isset($_POST["c_email"]) ? $_POST["c_email"] : '';
    $c_phone = isset($_POST["c_phone"]) ? $_POST["c_phone"] : '';
    $c_start = isset($_POST["c_start"]) ? $_POST["c_start"] : '';
    $c_end = isset($_POST["c_end"]) ? $_POST["c_end"] : '';
    $c_title = isset($_POST["c_title"]) ? $_POST["c_title"] : '';
    //variables used to store input for Capstone project details
    $deg_lvl = isset($_POST["degree_level"]) ? $_POST["degree_level"] : '';
    $skills = isset($_POST["skills_needed"]) ? $_POST["skills_needed"] : '';
    $mile_1 = isset($_POST["milestone_1"]) ? $_POST["milestone_1"] : '';
    $mile_2 = isset($_POST["milestone_2"]) ? $_POST["milestone_2"] : '';
    $final = isset($_POST["final_deliverables"]) ? $_POST["final_deliverables"] : '';
    $st_benefit = isset($_POST["student_benefits"]) ? $_POST["student_benefits"] : '';
    $sp_benefit = isset($_POST["sponsor_benefits"]) ? $_POST["sponsor_benefits"] : '';
    $provide = isset($_POST["company_provides"]) ? $_POST["company_provides"] : '';
    $nda_mou = isset($_POST["nda_or_mou"]) ? $_POST["nda_or_mou"] : '';
    $retain = isset($_POST["company_retain"]) ? $_POST["company_retain"] : '';
    $on_site = isset($_POST["work_on_site"]) ? $_POST["work_on_site"] : '';
    $sp_site = isset($_POST["work_sponsor_site"]) ? $_POST["work_sponsor_site"] : '';
    $c_present = isset($_POST["on_campus_present"]) ? $_POST["on_campus_present"] : '';
    $v_present = isset($_POST["virtual_present"]) ? $_POST["virtual_present"] : '';
    $teams = isset($_POST["num_of_teams"]) ? $_POST["num_of_teams"] : '';
    $available = isset($_POST["availability"]) ? $_POST["availability"] : '';
    //variable used to store input for Research project details
    $topic = isset($_POST["topic"]) ? $_POST["topic"] : '';
    //variable used to store input for Contract for Hire project details
    $address = isset($_POST["company_address"]) ? $_POST["company_address"] : '';
    $pay_1 = isset($_POST["first_payment_amt"]) ? $_POST["first_payment_amt"] : '';
    $pay_2 = isset($_POST["second_payment_amt"]) ? $_POST["second_payment_amt"] : '';
    // Count up how many of each Participant Category have been submitted in this form.
    // We'll use this to count through each type of participant added and INSERT them to the database.
    $facCount = (isset($_POST['f_lname'])) ? count($_POST["f_lname"]) : '';
    $staCount = (isset($_POST['sta_lname'])) ? count($_POST["sta_lname"]) : '';
    $stuCount = (isset($_POST['stu_lname'])) ? count($_POST["stu_lname"]) : '';
    $conCount = (isset($_POST['c_lname'])) ? count($_POST["c_lname"]) : '';
    $conn = null;
    try {
		// prepared sql statements to insert new record into the project table
		$conn = pdo_connect_mysql();
		$conn->beginTransaction();
		$stmt = $conn->prepare('INSERT INTO project (project_category, organization_name, project_title,
													 ksu_department,priority_level, start_date, end_date,
													 funded, total_cost, description, approval)
													 VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
		$stmt->execute([$category, $organization, $title, $dep, $priority, $start, $end, $fund, $cost, $desc, $approval]);
    //Store the auto incremented project id in a variable to be inseeted into its child table
    $id = $conn->lastInsertId();
    //end transaction and connection until next transaction and connection is initiated
		$conn->commit();
    $stmt = null;
		$conn = null;
    // insert new record into the project_participant table (sponsor only)
    $conn = pdo_connect_mysql();
    $conn->beginTransaction();
    $stmt = $conn->prepare('INSERT INTO project_participant (participant_category, last_name, first_name,
                           participant_org, email, phone, project_id)
                           VALUES(?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$sp_cat, $sp_last, $sp_first, $sp_org, $sp_email, $sp_phone, $id]);
    //end transaction and connection until next transaction and connection is initiated
    $conn->commit();
    $stmt = null;
    $conn = null;
    // insert new record into the project_participant table and faculty_and_staff table(faculty only)*/
    // Each of the 4 participant categroies (except sponsor) gets its own FOR loop
    // Count from the 1st Faculty value (if any) up to the last one
    for($count=0; $count <= $facCount; $count++) {
          if(isset($f_last[$count]) && isset($f_first[$count]) && isset($f_email[$count]))
          {
            $conn = pdo_connect_mysql();
            $conn->beginTransaction();
            $stmt = $conn->prepare('INSERT INTO project_participant (participant_category, last_name, first_name, participant_org, email, phone, project_id) VALUES(?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([$f_cat, $f_last[$count], $f_first[$count], $f_org[$count], $f_email[$count], $f_phone[$count], $id]);
            $f_id = $conn->lastInsertId();
            $conn->commit();
            $stmt = null;
            $conn = null;
            $conn = pdo_connect_mysql();
            $conn->beginTransaction();
            $stmt = $conn->prepare('INSERT INTO faculty_and_staff (participant_id, department, title)
                                  VALUES(?, ?, ?)');
            $stmt->execute([$f_id, $f_dept[$count], $f_title[$count]]);
            $conn->commit();
            $stmt = null;
            $conn = null;
          }
        }
    for($count=0; $count <= $staCount; $count++) {
            if(isset($sta_last[$count]) && isset($sta_first[$count]) && isset($sta_email[$count]))
            {
              $conn = pdo_connect_mysql();
              $conn->beginTransaction();
              $stmt = $conn->prepare('INSERT INTO project_participant (participant_category, last_name, first_name,
                                    participant_org, email, phone, project_id)
                                    VALUES(?, ?, ?, ?, ?, ?, ?)');
              $stmt->execute([$sta_cat, $sta_last[$count], $sta_first[$count], $sta_org[$count], $sta_email[$count], $sta_phone[$count], $id]);
              $sta_id = $conn->lastInsertId();
              $conn->commit();
              $stmt = null;
              $conn = null;
              $conn = pdo_connect_mysql();
              $conn->beginTransaction();
              $stmt = $conn->prepare('INSERT INTO faculty_and_staff (participant_id, department, title)
                                    VALUES(?, ?, ?)');
              $stmt->execute([$sta_id, $sta_dept[$count], $sta_title[$count]]);
              $conn->commit();
              $stmt = null;
              $conn = null;
            }
          }
    for($count=0; $count <= $stuCount; $count++) {
          if(isset($stu_last[$count]) && isset($stu_first[$count]) && isset($stu_email[$count]))
          {
            $conn = pdo_connect_mysql();
            $conn->beginTransaction();
            $stmt = $conn->prepare('INSERT INTO project_participant (participant_category, last_name, first_name, participant_org, email, phone, project_id)
                                  VALUES(?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([$stu_cat, $stu_last[$count], $stu_first[$count], $stu_org[$count], $stu_email[$count], $stu_phone[$count], $id]);
            $stu_id = $conn->lastInsertId();
            $conn->commit();
            $stmt = null;
            $conn = null;
            $conn = pdo_connect_mysql();
            $conn->beginTransaction();
            $stmt = $conn->prepare('INSERT INTO student (participant_id, major, degree_level)
                                  VALUES(?, ?, ?)');
            $stmt->execute([$stu_id, $major[$count], $stu_lvl[$count]]);
            $conn->commit();
            $stmt = null;
            $conn = null;
          }
    }
    for($count=0; $count <= $conCount; $count++) {
            if(isset($c_last[$count]) && isset($c_first[$count]) && isset($c_email[$count]))
            {
              $conn = pdo_connect_mysql();
              $conn->beginTransaction();
              $stmt = $conn->prepare('INSERT INTO project_participant (participant_category, last_name, first_name, participant_org, email, phone, project_id) VALUES(?, ?, ?, ?, ?, ?, ?)');
              $stmt->execute([$c_cat, $c_last[$count], $c_first[$count], $c_org[$count], $c_email[$count], $c_phone[$count], $id]);
              $c_id = $conn->lastInsertId();
              $conn->commit();
              $stmt = null;
              $conn = null;
              $conn = pdo_connect_mysql();
              $conn->beginTransaction();
              $stmt = $conn->prepare('INSERT INTO contractor (participant_id, contract_start_date, contract_end_date, title)
                                    VALUES(?, ?, ?, ?)');
              $stmt->execute([$c_id, $c_start[$count], $c_end[$count], $c_title[$count]]);
              $conn->commit();
              $stmt = null;
              $conn = null;
            }
          }
    //switch statement to insert data into a child table based on project category that the user chooses
		switch ($category) {
			case "Capstone":
				$conn = pdo_connect_mysql();
				$conn->beginTransaction();
				$stmt_2 = $conn->prepare('INSERT INTO capstone_project (degree_level, skills_needed, milestone_1, milestone_2,
                                  final_deliverables, student_benefits, sponsor_benefits, company_provides, nda_or_mou,
                                  company_retain, work_on_site, work_sponsor_site, on_campus_present, virtual_present,
                                  num_of_teams, availability, project_id)
				                          VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
				$stmt_2->execute([$deg_lvl, $skills, $mile_1, $mile_2, $final, $st_benefit, $sp_benefit, $provide, $nda_mou, $retain,
				$on_site, $sp_site, $c_present, $v_present, $teams, $available, $id]);
        $conn->commit();
				$stmt_2 = null;
				$conn = null;
			break;
			case "Contract for Hire":
                $conn = pdo_connect_mysql();
				$conn->beginTransaction();
				$stmt_3 = $conn->prepare('INSERT INTO contract_for_hire (company_address, first_payment_amt,
                                  second_payment_amt, project_id)
				                          VALUES(?, ?, ?, ?)');
				$stmt_3->execute([$address, $pay_1, $pay_2, $id]);
				$conn->commit();
				$stmt_3 = null;
				$conn = null;
			break;
			case "Research":
				$conn = pdo_connect_mysql();
				$conn->beginTransaction();
				$stmt_4 = $conn->prepare('INSERT INTO research_project (topic, project_id)
				                          VALUES(?, ?)');
				$stmt_4->execute([$topic, $id]);
				$conn->commit();
				$stmt_3 = null;
				$conn = null;
			break;
		}
} catch (Exception $e) {
      $conn->rollBack();
  } finally {
      $conn = null;
  }
    //message so the user can acknowledge an alert that the record was added.
    //URL in javascript below may need to be changed to one tht will work with the actual server!
    echo "<script type='text/JavaScript'>
    window.location.href = '/get_project.php';
    alert('Record Successfully Added.');
    </script>";
	}
?>
<!--javascript for dynamic project category form fields. This controls which following input fields are
displayed and required to be filled out based on the selection they make for "Project Category".
the fields are disabled unless they are called by this checkProjectCategory() function-->
<script>
  function checkProjectCategory() {
      if (document.getElementById('project_category').value == 'Capstone') {
        document.getElementById('capstone_fields').style.display = '';
        document.getElementById('grad').disabled = false;
        document.getElementById('undergrad').disabled = false;
        document.getElementById('skills_needed').disabled = false;
        document.getElementById('milestone_1').disabled = false;
        document.getElementById('milestone_2').disabled = false;
        document.getElementById('final_deliverables').disabled = false;
        document.getElementById('student_benefits').disabled = false;
        document.getElementById('sponsor_benefits').disabled = false;
        document.getElementById('company_provides').disabled = false;
        document.getElementById('yes_2').disabled = false;
        document.getElementById('no_2').disabled = false;
        document.getElementById('yes_3').disabled = false;
        document.getElementById('no_3').disabled = false;
        document.getElementById('yes_4').disabled = false;
        document.getElementById('no_4').disabled = false;
        document.getElementById('yes_5').disabled = false;
        document.getElementById('no_5').disabled = false;
        document.getElementById('yes_6').disabled = false;
        document.getElementById('no_6').disabled = false;
        document.getElementById('yes_7').disabled = false;
        document.getElementById('no_7').disabled = false;
        document.getElementById('num_of_teams').disabled = false;
        document.getElementById('availability').disabled = false;
        $('.capstone_fields').prop('required',true);
      } else {
        document.getElementById('capstone_fields').style.display = 'none';
        $('.capstone_fields').prop('required',false);
      }
      if (document.getElementById('project_category').value == 'Contract for Hire') {
        document.getElementById('contract_fields').style.display = '';
        document.getElementById('company_address').disabled = false;
        document.getElementById('first_payment_amt').disabled = false;
        document.getElementById('second_payment_amt').disabled = false;
        $('.contract_fields').prop('required',true);
      } else {
        document.getElementById('contract_fields').style.display = 'none';
        $('.contract_fields').prop('required',false);
      }
      if (document.getElementById('project_category').value == 'Research') {
        document.getElementById('research_fields').style.display = '';
        document.getElementById('topic').disabled = false;
        $('.research_fields').prop('required',true);
      } else {
        document.getElementById('research_fields').style.display = 'none';
        $('.research_fields').prop('required',false);
      }
}
</script>
<!--javascript to dynamically add rows for project participants-->
<script>
//function to dynamically delete rows and remove the table header is there are no rows present
function delete_row(rowno)
{
 $('#'+rowno).remove();
 $f = document.getElementById("faculty_table").rows.length;
 if ($f <= 1) {
 document.getElementById("f_row0").style.display = 'none';
 }
 $sta = document.getElementById("staff_table").rows.length;
 if ($sta <= 1) {
 document.getElementById("sta_row0").style.display = 'none';
 }
 $stu = document.getElementById("student_table").rows.length;
 if ($stu <= 1) {
 document.getElementById("stu_row0").style.display = 'none';
 }
 $c = document.getElementById("contractor_table").rows.length;
 if ($c <= 1) {
 document.getElementById("c_row0").style.display = 'none';
 }
}
//function to dynamically add the table header is there is at least one row present
function addHeader(table, row) {
  $x= document.getElementById(table).rows.length;
  if ($x > 1) {
    document.getElementById(row).style.display = '';
  }
}
//function to dynamically add empty faculty row for user to fill out
function add_f_row()
{
 $rowno=$("#faculty_table tr").length;
 $rowno=$rowno+1;
 $("#faculty_table tr:last").after("<tr id='f_row"+$rowno+"'>"
 +"<td><input type='text' name='f_lname[]' placeholder='Last Name' required></td>"
 +"<td><input type='text' name='f_fname[]' placeholder='First Name' required></td>"
 +"<td><input type='text' name='f_org[]' placeholder='Organization' required></td>"
 +"<td><input type='email' name='f_email[]' placeholder='Email' required></td>"
 +"<td><input type='text' name='f_phone[]' placeholder='Phone'></td>"
 +"<td><select name='f_dept[]' required><option value='' disabled selected>Select a Department</option>"
 +"<option value='Analytics and Data Science'>Analytics and Data Science</option>"
 +"<option value='Computer Science'>Computer Science</option>"
 +"<option value='Information Technology'>Information Technology</option>"
 +"<option value='Software Engineering and Game Development'>Software Engineering and Game Development</option></select></td>"
 +"<td><input type='text' name='f_title[]' placeholder='Title'></td>"
 +"<td><input type='button' value='DELETE' onclick=delete_row('f_row"+$rowno+"')></td></tr>");
}
//function to dynamically add empty Staff row for user to fill out
function add_sta_row()
{
 $rowno=$("#staff_table tr").length;
 $rowno=$rowno+1;
 $("#staff_table tr:last").after("<tr id='sta_row"+$rowno+"'>"
 +"<td><input type='text' name='sta_lname[]' placeholder='Last Name' required></td>"
 +"<td><input type='text' name='sta_fname[]' placeholder='First Name' required></td>"
 +"<td><input type='text' name='sta_org[]' placeholder='Organization' required></td>"
 +"<td><input type='email' name='sta_email[]' placeholder='Email' required></td>"
 +"<td><input type='text' name='sta_phone[]' placeholder='Phone'></td>"
 +"<td><select name='sta_dept[]' required><option value='' disabled selected>Select a Department</option>"
 +"<option value='Analytics and Data Science'>Analytics and Data Science</option>"
 +"<option value='Computer Science'>Computer Science</option>"
 +"<option value='Information Technology'>Information Technology</option>"
 +"<option value='Software Engineering and Game Development'>Software Engineering and Game Development</option></select></td>"
 +"<td><input type='text' name='sta_title[]' placeholder='Title'></td>"
 +"<td><input type='button' value='DELETE' onclick=delete_row('sta_row"+$rowno+"')></td></tr>");
}
//function to dynamically add empty Student row for user to fill out
function add_stu_row()
{
 $rowno=$("#student_table tr").length;
 $rowno=$rowno+1;
 $("#student_table tr:last").after("<tr id='stu_row"+$rowno+"'>"
 +"<td><input type='text' name='stu_lname[]' placeholder='Last Name' required></td>"
 +"<td><input type='text' name='stu_fname[]' placeholder='First Name' required></td>"
 +"<td><input type='text' name='stu_org[]' placeholder='Organization' required></td>"
 +"<td><input type='email' name='stu_email[]' placeholder='Email' required></td>"
 +"<td><input type='text' name='stu_phone[]' placeholder='Phone'></td>"
 +"<td><select name='major[]' required><option value='' disabled selected>Select a Major</option>"
 +"<option value='Applied Computer Science'>Applied Computer Science</option>"
 +"<option value='Computer Game Design and Development'>Computer Game Design and Development</option>"
 +"<option value='Computer Science'>Computer Science</option>"
 +"<option value='Information Technology (BAS)'>Information Technology (BAS)</option>"
 +"<option value='Information Technology (BS)'>Information Technology (BS)</option>"
 +"<option value='Software Engineering'>Software Engineering</option>"
 +"<option value='Analytics and Data Science'>Analytics and Data Science</option></select></td>"
 +"<td><select name='stu_lvl[]' required><option value='' disabled selected>Degree Level</option>"
 +"<option value='Bachelor of Science'>Bachelor of Science</option>"
 +"<option value='Master of Science'>Master of Science</option>"
 +"<option value='Doctor of Philosophy'>Doctor of Philosophy</option></select></td>"
 +"<td><input type='button' value='DELETE' onclick=delete_row('stu_row"+$rowno+"')></td></tr>");
}
//function to dynamically add empty Contractor row for user to fill out
function add_c_row()
{
 $c_rowno=$("#contractor_table tr").length;
 $c_rowno=$c_rowno+1;
 $("#contractor_table tr:last").after("<tr id='c_row"+$c_rowno+"'>"
 +"<td><input type='text' name='c_lname[]' placeholder='Last Name' required></td>"
 +"<td><input type='text' name='c_fname[]' placeholder='First Name' required></td>"
 +"<td><input type='text' name='c_org[]' placeholder='Organization' required></td>"
 +"<td><input type='email' name='c_email[]' placeholder='Email' required></td>"
 +"<td><input type='text' name='c_phone[]' placeholder='Phone'></td>"
 +"<td><input type='date' name='c_start[]' required></td>"
 +"<td><input type='date' name='c_end[]' required></td>"
 +"<td><input type='text' name='c_title[]' placeholder='Title'></td>"
 +"<td><input type='button' value='DELETE' onclick=delete_row('c_row"+$c_rowno+"')></td></tr>");
}
</script>

<!--Add in header from pmo_functions.php and insert the title of this page, "Create Project"-->
<?=template_header('Create Project')?>
<!--Start of container for Create Project section-->
<div class="container">
  <h1>Create a New Project</h1>
    <!--Link this form's actions to this file, create_project.php-->
    <form action="create_project.php" autocomplete="off" method="post">
      <h2>Section 1 - General Project Information</h2>
        <label for="project_category">Project Category :</label>
        <select onchange="checkProjectCategory()" id="project_category" name="project_category" required>
        <option value="" disabled selected>Select a Category</option>
        <option value="Capstone">Capstone</option>
        <option value="Contract for Hire">Contract for Hire</option>
        <option value="Research">Research</option>
        </select>
        <br />
        <label for="organization_name">Organization Name :</label>
        <input type="text" id="organization_name" name="organization_name" placeholder="ex./ Kennesaw State University" required>
        <br />
        <label for="project_title">Project Title :</label>
        <input type="text" id="project_title" name="project_title" placeholder="ex./ PMO Capstone" required>
        <br />
        <label for="ksu_department">KSU Department :</label>
        <select id="ksu_department" name="ksu_department" required>
        <option value="" disabled selected>Select a Department</option>
        <option value="Analytics and Data Science">Analytics and Data Science</option>
        <option value="Computer Science">Computer Science</option>
        <option value="Information Technology">Information Technology</option>
        <option value="Software Engineering and Game Development">Software Engineering and Game Development</option>
        </select>
        <br />
        <label for="priority_level">Priority Level :</label>
        <select required id="priority_level" name="priority_level" required>
        <option value="" disabled selected>Select a Priority Level</option>
        <option value="Low">Low</option>
        <option value="Medium">Medium</option>
        <option value="High">High</option>
        </select>
        <br />
        <label for="start_date">Start Date :</label>
        <input type="date" id="start_date" name="start_date" required>
        <br />
        <label for="end_date">End Date :</label>
        <input type="date" id="end_date" name="end_date" required>
        <br />
        <label for="funded">Is this project funded ?</label>
        <input type="radio" id="yes_1" name="funded" value="Yes"> Yes
        <input type="radio" id="no_1" name="funded" value="No"> No
        <input type="radio" id="n/a" name="funded" value="N/A" checked> N/A
        <br />
        <label for="total_cost">Total Cost : $</label>
        <input type="text" id="total_cost" name="total_cost" placeholder="Format: 0.00">
        <br />
        <label for="description">Description :</label>
        <input type="text" id="description" maxlength="600" name="description" placeholder="Type up to 600 characters." required>
        <br />
        <h2>Section 2 - Sponsor Information</h2>
        <label for="last_name">Last Name :</label>
        <input type="text" id="last_name" name="last_name" required>
        <br />
        <label for="first_name">First Name :</label>
        <input type="text" id="first_name" name="first_name" required>
        <br />
        <label for="participant_org">Sponsor's Organization Name :</label>
        <input type="text" id="participant_org" name="participant_org" required>
        <br />
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>
        <br />
        <label for="phone">Phone Number :</label>
        <input type="text" id="phone" name="phone" required>
        <br />
        <!--Beginning of dynamic project category form fields-->
        <!--capstone project fields-->
        <div id="capstone_fields" name="capstone_fields" style="display: none">
        <h2>Section 3 - Capstone Details</h2>
        <label for="degree_level" disabled>What is the degree level for this project?</label>
        <input type="radio" id="grad" name="degree_level" value="1" required disabled> Graduate
        <input type="radio" id="undergrad" name="degree_level" value="0" disabled> Undergraduate
        <br />
        <label for="skills_needed">Skills Needed :</label>
        <input type="text" id="skills_needed" name="skills_needed" class="capstone_fields" required disabled>
        <br />
        <label for="milestone_1">Milestone 1 Deliverables :</label>
        <input type="text" id="milestone_1" name="milestone_1" class="capstone_fields" required disabled>
        <br />
        <label for="milestone_2">Milestone 2 Deliverables :</label>
        <input type="text" id="milestone_2" name="milestone_2" class="capstone_fields" required disabled>
        <br />
        <label for="final_deliverables">Final Deliverables :</label>
        <input type="text" id="final_deliverables" name="final_deliverables" class="capstone_fields" required disabled>
        <br />
        <label for="student_benefits">How does this project benefit the student ?</label>
        <input type="text" id="student_benefits" name="student_benefits" class="capstone_fields" required disabled>
        <br />
        <label for="sponsor_benefits">How does this project benefit the sponsor ?</label>
        <input type="text" id="sponsor_benefits" name="sponsor_benefits" class="capstone_fields" required disabled>
        <br />
        <label for="company_provides">What will the company provide for the student ?</label>
        <input type="text" id="company_provides" name="company_provides" class="capstone_fields" required disabled>
        <br />
        <label for="nda_or_mou" disabled>Will this project require a NDA or MOU ?</label>
        <input type="radio" id="yes_2" name="nda_or_mou" value="1" required disabled> Yes
        <input type="radio" id="no_2" name="nda_or_mou" value="0" disabled> No
        <br />
        <label for="company_retain" disabled>Does the company wish to retain IP ?</label>
        <input type="radio" id="yes_3" name="company_retain" value="1" required disabled> Yes
        <input type="radio" id="no_3" name="company_retain" value="0" disabled> No
        <br />
        <label for="work_on_site" disabled>Will this project require students to work on site ?</label>
        <input type="radio" id="yes_4" name="work_on_site" value="1" required disabled> Yes
        <input type="radio" id="no_4" name="work_on_site" value="0" disabled> No
        <br />
        <label for="work_sponsor_site" disabled>Will students be required to present at the sponsor’s site ?</label>
        <input type="radio" id="yes_5" name="work_sponsor_site" value="1" required disabled> Yes
        <input type="radio" id="no_5" name="work_sponsor_site" value="0" disabled> No
        <br />
        <label for="on_campus_present" disabled>Would you like to make an on campus presentation the first week of classes ?</label>
        <input type="radio" id="yes_6" name="on_campus_present" value="1" required disabled> Yes
        <input type="radio" id="no_6" name="on_campus_present" value="0" disabled disabled> No
        <br />
        <label for="virtual_present" disabled>If you are unavailable for an on campus presentation,would you like to provide a video presentation ?</label>
        <input type="radio" id="yes_7" name="virtual_present" value="1" required disabled> Yes
        <input type="radio" id="no_7" name="virtual_present" value="0" disabled> No
        <br />
        <label for="num_of_teams">How many student teams are you interested in sponsoring ?</label>
        <select required id="num_of_teams" name="num_of_teams" class="capstone_fields" disabled>
        <option value="" disabled selected>Make Selection</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        </select>
        <br />
        <label for="availability">Please describe your availability :</label>
        <input type="text" id="availability" name="availability" class="capstone_fields" required disabled>
        <br />
        </div>
        <!--research project fields-->
        <div id="research_fields" name="research_fields" style="display: none">
        <h2>Section 3 - Research Details</h2>
        <label for="topic">Topic :</label>
        <input type="text" id="topic" name="topic" class="research_fields" required disabled>
        <br />
        </div>
        <!--contract project fields-->
        <div id="contract_fields" name="contract_fields" style="display: none">
        <h2>Section 3 - Contract for Hire Details</h2>
        <label for="company_address">Company Address :</label>
        <input type="text" id="company_address" name="company_address" class="contract_fields" required disabled>
        <br />
        <label for="first_payment_amt">First Payment Amount :</label>
        <input type="text" id="first_payment_amt" name="first_payment_amt" class="contract_fields" required disabled>
        <br />
        <label for="second_payment_amt">Second Payment Amount :</label>
        <input type="text" id="second_payment_amt" name="second_payment_amt" class="contract_fields" required disabled>
        <br />
        </div>
        <!--End of dynamic project category form fields-->
        <h2>Optional - Add Project Participants</h2>
        <h3>Faculty</h3>
        <table id="faculty_table" align=center>
          <tr id="f_row0" style="display: none;"><th>Last Name</th><th>First Name</th><th>Organization</th><th>Email</th>
                          <th>Phone</th><th>Department</th><th>Title</th></tr>
        </table>
        <input type="button" onclick="add_f_row(); addHeader('faculty_table', 'f_row0')" value="ADD FACULTY">
        <h3>Staff</h3>
        <table id="staff_table" align=center>
          <tr id="sta_row0" style="display: none;"><th>Last Name</th><th>First Name</th><th>Organization</th><th>Email</th>
                          <th>Phone</th><th>Department</th><th>Title</th></tr>
        </table>
        <input type="button" onclick="add_sta_row(); addHeader('staff_table', 'sta_row0')" value="ADD STAFF">
        <h3>Students</h3>
        <table id="student_table" align=center>
          <tr id="stu_row0" style="display: none;"><th>Last Name</th><th>First Name</th><th>Organization</th><th>Email</th>
                          <th>Phone</th><th>Major</th><th>Degree Level</th></tr>
        </table>
        <input type="button" onclick="add_stu_row(); addHeader('student_table', 'stu_row0')" value="ADD STUDENT">
        <h3>Contractors</h3>
        <table id="contractor_table" align=center>
          <tr id="c_row0" style="display: none;"><th>Last Name</th><th>First Name</th><th>Organization</th><th>Email</th>
                          <th>Phone</th><th>Contract Start</th><th>Contract End</th><th>Title</th></tr>
        </table>
        <input type="button" onclick="add_c_row(); addHeader('contractor_table', 'c_row0')" value="ADD CONTRACTOR">
        <!--Approval Status with Admin Permission only-->
        <h2>Admin Use Only</h2>
        <?php if($_SESSION['adminCheck'] == 1): ?>
          <label for="approval">Approval Status :</label>
          <input type="radio" id="approved" name="approval" value="Approved"> Approved
          <input type="radio" id="disapproved" name="approval" value="Disapproved"> Disapproved
          <input type="radio" id="pending" name="approval" value="Pending" checked> Pending
        <?php else: ?>
          <label for="approval">Approval Status :</label>
          <input type="radio" id="approved" name="approval" value="Approved" disabled> Approved
          <input type="radio" id="disapproved" name="approval" value="Disapproved" disabled> Disapproved
          <input type="radio" id="pending" name="approval" value="Pending" checked disabled> Pending
        <?php endif; ?> <!--end of admin check -->
        <br />
        <input type="submit" id="submit_btn" value="Submit">
        <br />
    </form>
</div>
<!--end of create project section container-->
<!--Add in footer from pmo_functions.php-->
<?=template_footer()?>

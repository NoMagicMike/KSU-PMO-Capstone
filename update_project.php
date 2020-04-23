<?php
// Report all errors
error_reporting(E_ALL);
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
// Include the pmo_functions.php file to add header, footer, and navbar
require 'pmo_functions.php';
// Check if the project_id exists
if (isset($_GET['project_id'])) {
    //make sure post data is not empty
    if (!empty($_POST)) {
        // This part is similar to the create_project.php, but instead we use this to update a record instead of creating one
        $category = isset($_POST["project_category"]) ? $_POST["project_category"] : '';
        $organization = isset($_POST["organization_name"]) ? $_POST["organization_name"] : '';
        $title = isset($_POST["project_title"]) ? $_POST["project_title"] : '';
        $dep = isset($_POST["ksu_department"]) ? $_POST["ksu_department"] : '';
        $priority = isset($_POST["priority_level"]) ? $_POST["priority_level"] : '';
        $start = isset($_POST["start_date"]) ? $_POST["start_date"] : '';
        $end = isset($_POST["end_date"]) ? $_POST["end_date"] : '';
        $fund = isset($_POST["funded"]) ? $_POST["funded"] : '';
        $cost = isset($_POST["total_cost"]) ? $_POST["total_cost"] : '';
        $des = isset($_POST["description"]) ? $_POST["description"] : '';
        $approval = isset($_POST["approval"]) ? $_POST["approval"] : '';
        $conn = null;
        try {
            //Update general project information in `project` table
            $conn = pdo_connect_mysql();
            $conn->beginTransaction();
            $stmt = $conn->prepare('UPDATE project SET project_category = ?, organization_name = ?, project_title = ?, ksu_department = ?, priority_level = ?, start_date = ?, end_date = ?, funded = ?, total_cost = ?, description = ?, approval = ?
            WHERE project_id = ?');
            $stmt->execute([$category, $organization, $title, $dep, $priority, $start, $end,
            $fund, $cost, $des, $approval, $_GET['project_id']]);
            $conn->commit();
            $stmt = null;
            $conn = null;
            // Count up how many of each Participant Category have been submitted in this form.
            // We'll use this later to count through it and perform operations.
            $facCount = (isset($_POST['f_lname'])) ? count($_POST["f_lname"]) : '';
            $staCount = (isset($_POST['sta_lname'])) ? count($_POST["sta_lname"]) : '';
            $stuCount = (isset($_POST['stu_lname'])) ? count($_POST["stu_lname"]) : '';
            $conCount = (isset($_POST['c_lname'])) ? count($_POST["c_lname"]) : '';
            // Initialize array to hold ALL Participant IDs that already exist except for the Sponsor.
            // We will use this to compare if any have been removed b/c the user selected DELETE in the UI
            // example: if we get 12, 13,14,16, 17 as IDs
            // BUT when the form submits we see that id 13 is missing.
            // That means the user "deleted" 13 and we must delete that record.
            // This executes when the user submits the updated form
            $participantList = array();
            $conn = pdo_connect_mysql();
            $stmt = $conn->prepare('SELECT * FROM project_participant
                  WHERE project_id = ? AND participant_category != "Sponsor"');
            $stmt->execute([$_GET['project_id']]);
            //fill the array with the Participant IDs
            while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
              $participantList[] = $result['participant_id'];
            }
            // Compare the list of Participants on this project with the list the user is submitting in the update.
            // any missing participants means the user selected DELETE for that participant
            // build the list of Participant IDs that were submitted in the update
            $participantsSubmitted = array();
            if (isset($_POST['f_participantid']) && $facCount > 0) $participantsSubmitted = array_merge($participantsSubmitted, $_POST['f_participantid']);
            if (isset($_POST['sta_participantid']) && $staCount > 0) $participantsSubmitted = array_merge($participantsSubmitted, $_POST['sta_participantid']);
            if (isset($_POST['stu_participantid']) && $stuCount > 0) $participantsSubmitted = array_merge($participantsSubmitted, $_POST['stu_participantid']);
            if (isset($_POST['c_participantid']) && $conCount > 0) $participantsSubmitted = array_merge($participantsSubmitted, $_POST['c_participantid']);
            // Delete any Participant record that was in the original form but is missing from the form submission
            $allParticipants = explode(',', $_POST['all_participant_ids']);
            $conn = pdo_connect_mysql();
            foreach ($allParticipants as $key=>$val) {
              if (!in_array($val, $participantsSubmitted)) {
                $conn->beginTransaction();
                // $deleteParticipantSQL = 'DELETE FROM project_participant
                //                      WHERE participant_id = ?';
                $stmt = $conn->prepare('DELETE FROM project_participant
                WHERE participant_id = ?')->execute([$val]);
                $conn->commit();
                $stmt = null;
              }
            }
            $conn = null;
            /*Now update ALL participant records even if no data changed. Take the LARGE $_POST array and break
            it down into individual arrays. Create an array for each field*/
            //variables used to store input for Faculty
            $f_last = isset($_POST["f_lname"]) ? $_POST["f_lname"] : '';
            $f_first = isset($_POST["f_fname"]) ? $_POST["f_fname"] : '';
            $f_org = isset($_POST["f_org"]) ? $_POST["f_org"] : '';
            $f_email = isset($_POST["f_email"]) ? $_POST["f_email"] : '';
            $f_phone = isset($_POST["f_phone"]) ? $_POST["f_phone"] : '';
            $f_dept = isset($_POST["f_dept"]) ? $_POST["f_dept"] : '';
            $f_title = isset($_POST["f_title"]) ? $_POST["f_title"] : '';
            $f_cat = "Faculty";
            // Each of the 4 categroies gets its own FOR loop
            // Count from the 1st Faculty value (if any) up to the last one
            for($count=0; $count <= $facCount; $count++) {
                $conn = pdo_connect_mysql();
                $conn->beginTransaction();
                if (isset($_POST['f_participantid'][$count])) {
                  $stmt = $conn->prepare('UPDATE project_participant
                                  SET last_name = ?, first_name = ?, participant_org = ?, email = ?, phone = ?
                                  WHERE participant_id = ?');
                  $stmt->execute([$f_last[$count], $f_first[$count], $f_org[$count], $f_email[$count], $f_phone[$count], $_POST['f_participantid'][$count]]);
                  $conn->commit();
                  $stmt = null;
                  $conn = null;
                  $conn = pdo_connect_mysql();
                  $conn->beginTransaction();
                  $stmt = $conn->prepare('SELECT * FROM faculty_and_staff
                                          WHERE participant_id = ?');
                  $stmt->execute([$_POST['f_participantid'][$count]]);
                  $existFaculty = $stmt->fetch(PDO::FETCH_ASSOC);
                  if ($existFaculty) {
                      $stmt = null;
                      $conn = null;
                      $conn = pdo_connect_mysql();
                      $conn->beginTransaction();
                      $stmt = $conn->prepare('UPDATE faculty_and_staff
                                              SET department = ?, title = ?
                                              WHERE participant_id = ?');
                      $stmt->execute([$f_dept[$count], $f_title[$count], $_POST['f_participantid'][$count]]);
                      $conn->commit();
                      $stmt = null;
                      $conn = null;
                  } else {
                    $stmt = null;
                    $conn = null;
                    $conn = pdo_connect_mysql();
                    $conn->beginTransaction();
                    $stmt = $conn->prepare('INSERT INTO faculty_and_staff (participant_id, department, title)
                                            VALUES(?, ?, ?)');
                    $stmt->execute([$_POST['f_participantid'][$count], $f_dept[$count], $f_title[$count]]);
                    $conn->commit();
                    $stmt = null;
                    $conn = null;
                  }
                } else {
                  if(isset($f_last[$count]) && isset($f_first[$count]) && isset($f_email[$count]))
                  {
                    $conn = pdo_connect_mysql();
                    $conn->beginTransaction();
                    $stmt = $conn->prepare('INSERT INTO project_participant (participant_category, last_name, first_name, participant_org, email, phone, project_id) VALUES(?, ?, ?, ?, ?, ?, ?)');
                    $stmt->execute([$f_cat, $f_last[$count], $f_first[$count], $f_org[$count], $f_email[$count], $f_phone[$count], $_GET['project_id']]);
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
            }
            //variables used to store input for Staff
            $sta_cat = "Staff";
            $sta_last = isset($_POST["sta_lname"]) ? $_POST["sta_lname"] : '';
            $sta_first = isset($_POST["sta_fname"]) ? $_POST["sta_fname"] : '';
            $sta_org = isset($_POST["sta_org"]) ? $_POST["sta_org"] : '';
            $sta_email = isset($_POST["sta_email"]) ? $_POST["sta_email"] : '';
            $sta_phone = isset($_POST["sta_phone"]) ? $_POST["sta_phone"] : '';
            $sta_dept = isset($_POST["sta_dept"]) ? $_POST["sta_dept"] : '';
            $sta_title = isset($_POST["sta_title"]) ? $_POST["sta_title"] : '';
            for($count=0; $count <= $staCount; $count++) {
                  $conn = pdo_connect_mysql();
                  $conn->beginTransaction();
                  if (isset($_POST['sta_participantid'][$count])) {
                    $stmt = $conn->prepare('UPDATE project_participant
                                    SET last_name = ?, first_name = ?, participant_org = ?, email = ?, phone = ?
                                    WHERE participant_id = ?');
                    $stmt->execute([$sta_last[$count], $sta_first[$count], $sta_org[$count], $sta_email[$count], $sta_phone[$count], $_POST['sta_participantid'][$count]]);
                    $conn->commit();
                    $stmt = null;
                    $conn = null;
                    $conn = pdo_connect_mysql();
                    $conn->beginTransaction();
                    $stmt = $conn->prepare('SELECT * FROM faculty_and_staff WHERE participant_id = ?');
                    $stmt->execute([$_POST['sta_participantid'][$count]]);
                    $existStaff = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($existStaff) {
                      $stmt = null;
                      $conn = null;
                      $conn = pdo_connect_mysql();
                      $conn->beginTransaction();
                      $stmt = $conn->prepare('UPDATE faculty_and_staff
                                      SET department = ?, title = ?
                                      WHERE participant_id = ?');
                      $stmt->execute([$sta_dept[$count], $sta_title[$count], $_POST['sta_participantid'][$count]]);
                      $conn->commit();
                    } else {
                      $stmt = null;
                      $conn = null;
                      $conn = pdo_connect_mysql();
                      $conn->beginTransaction();
                      $stmt = $conn->prepare('INSERT INTO faculty_and_staff (participant_id, department, title)
                                            VALUES(?, ?, ?)');
                      $stmt->execute([$_POST['sta_participantid'][$count], $sta_dept[$count], $sta_title[$count]]);
                      $conn->commit();
                      $stmt = null;
                      $conn = null;
                    }
                  } else {
                    if(isset($sta_last[$count]) && isset($sta_first[$count]) && isset($sta_email[$count]))
                    {
                      $conn = pdo_connect_mysql();
                      $conn->beginTransaction();
                      $stmt = $conn->prepare('INSERT INTO project_participant (participant_category, last_name, first_name,
                                            participant_org, email, phone, project_id)
                                            VALUES(?, ?, ?, ?, ?, ?, ?)');
                      $stmt->execute([$sta_cat, $sta_last[$count], $sta_first[$count], $sta_org[$count], $sta_email[$count], $sta_phone[$count], $_GET['project_id']]);
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
            }
            //variables used to store input for Student
            $stu_cat = "Student";
            $stu_last = isset($_POST["stu_lname"]) ? $_POST["stu_lname"] : '';
            $stu_first = isset($_POST["stu_fname"]) ? $_POST["stu_fname"] : '';
            $stu_org = isset($_POST["stu_org"]) ? $_POST["stu_org"] : '';
            $stu_email = isset($_POST["stu_email"]) ? $_POST["stu_email"] : '';
            $stu_phone = isset($_POST["stu_phone"]) ? $_POST["stu_phone"] : '';
            $major = isset($_POST["major"]) ? $_POST["major"] : '';
            $stu_lvl = isset($_POST["stu_lvl"]) ? $_POST["stu_lvl"] : '';
            for($count=0; $count <= $stuCount; $count++) {
                $conn = pdo_connect_mysql();
                $conn->beginTransaction();
                if (isset($_POST['stu_participantid'][$count])) {
                  $stmt = $conn->prepare('UPDATE project_participant
                                  SET last_name = ?, first_name = ?, participant_org = ?, email = ?, phone = ?
                                  WHERE participant_id = ?');
                  $stmt->execute([$stu_last[$count], $stu_first[$count], $stu_org[$count], $stu_email[$count], $stu_phone[$count], $_POST['stu_participantid'][$count]]);
                  $conn->commit();
                  $stmt = null;
                  $conn = null;
                  $conn = pdo_connect_mysql();
                  $conn->beginTransaction();
                  $stmt = $conn->prepare('SELECT * FROM student WHERE participant_id = ?');
                  $stmt->execute([$_POST['stu_participantid'][$count]]);
                  $existStudent = $stmt->fetch(PDO::FETCH_ASSOC);
                  if ($existStudent) {
                    $stmt = null;
                    $conn = null;
                    $conn = pdo_connect_mysql();
                    $conn->beginTransaction();
                    $stmt = $conn->prepare('UPDATE student
                                    SET major = ?, degree_level = ?
                                    WHERE participant_id = ?');
                    $stmt->execute([$major[$count], $stu_lvl[$count], $_POST['stu_participantid'][$count]]);
                    $conn->commit();
                  } else {
                    $stmt = null;
                    $conn = null;
                    $conn = pdo_connect_mysql();
                    $conn->beginTransaction();
                    $stmt = $conn->prepare('INSERT INTO student (participant_id, major, degree_level)
                                          VALUES(?, ?, ?)');
                    $stmt->execute([$_POST['stu_participantid'][$count], $major[$count], $stu_lvl[$count]]);
                    $conn->commit();
                    $stmt = null;
                    $conn = null;
                  }
                } else {
                  if(isset($stu_last[$count]) && isset($stu_first[$count]) && isset($stu_email[$count]))
                  {
                    $conn = pdo_connect_mysql();
                    $conn->beginTransaction();
                    $stmt = $conn->prepare('INSERT INTO project_participant (participant_category, last_name, first_name, participant_org, email, phone, project_id)
                                          VALUES(?, ?, ?, ?, ?, ?, ?)');
                    $stmt->execute([$stu_cat, $stu_last[$count], $stu_first[$count], $stu_org[$count], $stu_email[$count], $stu_phone[$count], $_GET['project_id']]);
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
            }
            //variables used to store input for Contractors
            $c_last = isset($_POST["c_lname"]) ? $_POST["c_lname"] : '';
            $c_first = isset($_POST["c_fname"]) ? $_POST["c_fname"] : '';
            $c_org = isset($_POST["c_org"]) ? $_POST["c_org"] : '';
            $c_email = isset($_POST["c_email"]) ? $_POST["c_email"] : '';
            $c_phone = isset($_POST["c_phone"]) ? $_POST["c_phone"] : '';
            $c_start = isset($_POST["c_start"]) ? $_POST["c_start"] : '';
            $c_end = isset($_POST["c_end"]) ? $_POST["c_end"] : '';
            $c_title = isset($_POST["c_title"]) ? $_POST["c_title"] : '';
            $c_cat = "Contractor";
            for($count=0; $count <= $conCount; $count++) {
                  $conn = pdo_connect_mysql();
                  $conn->beginTransaction();
                  if (isset($_POST['c_participantid'][$count])) {
                    $stmt = $conn->prepare('UPDATE project_participant
                                    SET last_name = ?, first_name = ?, participant_org = ?, email = ?, phone = ?
                                    WHERE participant_id = ?');
            $stmt->execute([$c_last[$count], $c_first[$count], $c_org[$count], $c_email[$count], $c_phone[$count], $_POST['c_participantid'][$count]]);
                    $conn->commit();
                    $stmt = null;
                    $conn = null;
                    $conn = pdo_connect_mysql();
                    $conn->beginTransaction();
                    $stmt = $conn->prepare('SELECT * FROM contractor
                                    WHERE participant_id = ?');
                    $stmt->execute([$_POST['c_participantid'][$count]]);
                    $existContractor = $stmt->fetch(PDO::FETCH_ASSOC);
                    $conn->commit();
                    $stmt = null;
                    $conn = null;
                    if ($existContractor) {
                      $stmt = null;
                      $conn = null;
                      $conn = pdo_connect_mysql();
                      $conn->beginTransaction();
                      $stmt = $conn->prepare('UPDATE contractor
                                      SET contract_start_date = ?, contract_end_date = ?, title = ?
                                      WHERE participant_id = ?');
                      $stmt->execute([$c_start[$count], $c_end[$count], $c_title[$count], $_POST['c_participantid'][$count]]);
                      $conn->commit();
                      $stmt = null;
                      $conn = null;
                    } else {
                      $stmt = null;
                      $conn = null;
                      $conn = pdo_connect_mysql();
                      $conn->beginTransaction();
                      $stmt = $conn->prepare('INSERT INTO contractor (participant_id, contract_start_date, contract_end_date, title)
                                            VALUES(?, ?, ?, ?)');
                      $stmt->execute([$_POST['c_participantid'][$count], $c_start[$count], $c_end[$count], $c_title[$count]]);
                      $conn->commit();
                      $stmt = null;
                      $conn = null;
                    }
                  } else {
                    if(isset($c_last[$count]) && isset($c_first[$count]) && isset($c_email[$count]))
                    {
                      $conn = pdo_connect_mysql();
                      $conn->beginTransaction();
                      $stmt = $conn->prepare('INSERT INTO project_participant (participant_category, last_name, first_name, participant_org, email, phone, project_id) VALUES(?, ?, ?, ?, ?, ?, ?)');
                      $stmt->execute([$c_cat, $c_last[$count], $c_first[$count], $c_org[$count], $c_email[$count], $c_phone[$count], $_GET['project_id']]);
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
            }
            $conn = pdo_connect_mysql();
            $conn->beginTransaction();
            $deleteCaptoneSQL = "DELETE FROM capstone_project
                                 WHERE project_id = ?";
            $stmt = $conn->prepare('DELETE FROM capstone_project
            WHERE project_id = ?')->execute([$_GET['project_id']]);
            $conn->commit();
            $stmt = null;
            $conn = null;
            $conn = pdo_connect_mysql();
            $conn->beginTransaction();
            $deleteContractForHireSQL = "DELETE FROM contract_for_hire
                                         WHERE project_id = ?";
            $stmt = $conn->prepare($deleteContractForHireSQL)->execute([$_GET['project_id']]);
            $conn->commit();
            $stmt = null;
            $conn = null;
            $conn = pdo_connect_mysql();
            $conn->beginTransaction();
            $deleteResearchSQL = "DELETE FROM research_project
                                  WHERE project_id = ?";
            $stmt = $conn->prepare($deleteResearchSQL)->execute([$_GET['project_id']]);
            $conn->commit();
            $stmt = null;
            $conn = null;
            //variables used to store input for Sponsor
            $last = isset($_POST["last_name"]) ? $_POST["last_name"] : '';
            $first = isset($_POST["first_name"]) ? $_POST["first_name"] : '';
            $par_org = isset($_POST["participant_org"]) ? $_POST["participant_org"] : '';
            $email = isset($_POST["email"]) ? $_POST["email"] : '';
            $phone = isset($_POST["phone"]) ? $_POST["phone"] : '';
            $conn = pdo_connect_mysql();
            $conn->beginTransaction();
            $stmt = $conn->prepare('UPDATE project_participant
                                    SET last_name = ?, first_name = ?, participant_org = ?, email = ?, phone = ?
                                    WHERE project_id = ?
                                    AND participant_category = "Sponsor"');
            $stmt->execute([$last, $first, $par_org, $email, $phone, $_GET['project_id']]);
            //end transaction and connection until next transaction and connection is initiated
            $conn->commit();
            $stmt = null;
            $conn = null;
            //switch statement to insert data into a child table based on project category that the user chooses
            switch ($category) {
                case "Capstone":
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
                    $conn = pdo_connect_mysql();
                    $conn->beginTransaction();
                    $stmt = $conn->prepare('INSERT INTO capstone_project (degree_level, skills_needed, milestone_1,
                                              milestone_2, final_deliverables, student_benefits, sponsor_benefits,
                                              company_provides, nda_or_mou, company_retain, work_on_site,
                                              work_sponsor_site, on_campus_present, virtual_present, num_of_teams,
                                              availability,project_id)
                                              VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
                    $stmt->execute([$deg_lvl, $skills, $mile_1, $mile_2, $final, $st_benefit, $sp_benefit, $provide, $nda_mou, $retain,$on_site, $sp_site, $c_present, $v_present, $teams, $available, $_GET['project_id']]);
                    $conn->commit();
                    $stmt = null;
                    $conn = null;
                    break;
                case "Contract for Hire":
                    $address = isset($_POST["company_address"]) ? $_POST["company_address"] : '';
                    $pay_1 = isset($_POST["first_payment_amt"]) ? $_POST["first_payment_amt"] : '';
                    $pay_2 = isset($_POST["second_payment_amt"]) ? $_POST["second_payment_amt"] : '';
                    $conn = pdo_connect_mysql();
            				$conn->beginTransaction();
                    $stmt = $conn->prepare('INSERT INTO contract_for_hire (company_address, first_payment_amt,
                                            second_payment_amt, project_id)
                                            VALUES(?,?,?,?)');
                    $stmt->execute([$address, $pay_1, $pay_2, $_GET['project_id']]);
                    $conn->commit();
                    $stmt = null;
                    $conn = null;
                    break;
                case "Research":
                    $topic = isset($_POST["topic"]) ? $_POST["topic"] : '';
                    $conn = pdo_connect_mysql();
            				$conn->beginTransaction();
                    $stmt = $conn->prepare('INSERT INTO research_project (topic, project_id)
                                            VALUES(?,?)');
                    $stmt->execute([$topic, $_GET['project_id']]);
                    $conn->commit();
                    $stmt = null;
                    $conn = null;
                    break;
            }
        } catch (Exception $e) {
          if ($conn) {
            //$conn->rollBack();
          }
        } finally {
            $conn = null;
        }
        //javascript to pop up a message so the user can acknowledge an alert that the record was updated.
        //URL below will need to be changed to one tht will work with the actual server!
      	echo "<script type='text/JavaScript'>
            var uri = window.location.href.substring(0, window.location.href.lastIndexOf('/'));
              window.location.href = uri + '/get_project.php';
      	      alert('Record Successfully Updated.');
      	      </script>";
    }
    // These all execute when the page first loads and we need to get all initial project information
    // Get the specified project from the project table
    $conn = pdo_connect_mysql();
    $stmt = $conn->prepare('SELECT * FROM project
                            WHERE project_id = ?');
    $stmt->execute([$_GET['project_id']]);
    $project = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$project) {
        die ('Project doesn\'t exist with that ID!');
    }
    // Get the project participants with the matching project ID
    $stmt = $conn->prepare('SELECT * FROM project_participant
                            WHERE project_id = ?');
    $stmt->execute([$_GET['project_id']]);
    // Initialize the array to hold ALL IDs that were returned when page loads
    // We will use this to compare if any have been removed b/c the user selected DELETE for any of these participants in the UI
    $participantList = array();
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
      if ($result['participant_category'] != 'Sponsor') {
        $participantList[] = $result['participant_id'];
      }
      $other_participants[$result['participant_category']][] = $result;
    }
    $sponsor = $other_participants['Sponsor'][0];
    $project = array_merge($project, $sponsor);
    // based on what the selected project's category is, get the data from its project category child table
    switch ($project['project_category']) {
      case "Capstone" :
        $stmt = $conn->prepare('SELECT * FROM capstone_project
                                  WHERE project_id = ?');
        $stmt->execute([$_GET['project_id']]);
        $ca_project = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$ca_project) {
            die ('Project doesn\'t exist with that ID!');
        }
        $project = array_merge($project, $ca_project);
        break;
      case "Contract for Hire" :
        $stmt = $conn->prepare('SELECT * FROM contract_for_hire
                                  WHERE project_id = ?');
        $stmt->execute([$_GET['project_id']]);
        $contract = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$contract) {
            die ('Project doesn\'t exist with that ID!');
        }
        $project = array_merge($project, $contract);
        break;
      case "Research" :
        $stmt = $conn->prepare('SELECT * FROM research_project
                                  WHERE project_id = ?');
        $stmt->execute([$_GET['project_id']]);
        $research = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$research) {
            die ('Project doesn\'t exist with that ID!');
        }
        $project = array_merge($project,$research);
        break;
    }
} else {
    die ('No ID specified!');
}
?>
<!--javascript to dynamically delete existing rows, and add rows to create new project participants-->
<script>
  //function to dynamically delete rows and remove the table header is there are no rows present
  function delete_row(rowno) {
    $('#' + rowno).remove();
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
    $x = document.getElementById(table).rows.length;
    if ($x > 1) {
      document.getElementById(row).style.display = '';
    }
  }
  //function to dynamically add empty faculty row
  function add_f_row() {
    $rowno = $("#faculty_table tr").length;
    $rowno = $rowno + 1;
    $("#faculty_table tr:last").after("<tr id='f_row" + $rowno + "'>" +
      "<td><input type='text' name='f_lname[]' placeholder='Last Name' required></td>" +
      "<td><input type='text' name='f_fname[]' placeholder='First Name' required></td>" +
      "<td><input type='text' name='f_org[]' placeholder='Organization' required></td>" +
      "<td><input type='email' name='f_email[]' placeholder='Email' required></td>" +
      "<td><input type='text' name='f_phone[]' placeholder='Phone'></td>" +
      "<td><select name='f_dept[]' required><option value='' disabled selected>Select a Department</option>" +
      "<option value='Analytics and Data Science'>Analytics and Data Science</option>" +
      "<option value='Computer Science'>Computer Science</option>" +
      "<option value='Information Technology'>Information Technology</option>" +
      "<option value='Software Engineering and Game Development'>Software Engineering and Game Development</option></select></td>" +
      "<td><input type='text' name='f_title[]' placeholder='Title'></td>" +
      "<td><input type='button' value='DELETE' onclick=delete_row('f_row" + $rowno + "')></td></tr>");
  }
  //function to dynamically add empty Staff row
  function add_sta_row() {
    $rowno = $("#staff_table tr").length;
    $rowno = $rowno + 1;
    $("#staff_table tr:last").after("<tr id='sta_row" + $rowno + "'>" +
      "<td><input type='text' name='sta_lname[]' placeholder='Last Name' required></td>" +
      "<td><input type='text' name='sta_fname[]' placeholder='First Name' required></td>" +
      "<td><input type='text' name='sta_org[]' placeholder='Organization' required></td>" +
      "<td><input type='email' name='sta_email[]' placeholder='Email' required></td>" +
      "<td><input type='text' name='sta_phone[]' placeholder='Phone'></td>" +
      "<td><select name='sta_dept[]' required><option value='' disabled selected>Select a Department</option>" +
      "<option value='Analytics and Data Science'>Analytics and Data Science</option>" +
      "<option value='Computer Science'>Computer Science</option>" +
      "<option value='Information Technology'>Information Technology</option>" +
      "<option value='Software Engineering and Game Development'>Software Engineering and Game Development</option></select></td>" +
      "<td><input type='text' name='sta_title[]' placeholder='Title'></td>" +
      "<td><input type='button' value='DELETE' onclick=delete_row('sta_row" + $rowno + "')></td></tr>");
  }
  //function to dynamically add empty Student row
  function add_stu_row() {
    $rowno = $("#student_table tr").length;
    $rowno = $rowno + 1;
    $("#student_table tr:last").after("<tr id='stu_row" + $rowno + "'>" +
      "<td><input type='text' name='stu_lname[]' placeholder='Last Name' required></td>" +
      "<td><input type='text' name='stu_fname[]' placeholder='First Name' required></td>" +
      "<td><input type='text' name='stu_org[]' placeholder='Organization' required></td>" +
      "<td><input type='email' name='stu_email[]' placeholder='Email' required></td>" +
      "<td><input type='text' name='stu_phone[]' placeholder='Phone'></td>" +
      "<td><select name='major[]' required><option value='' disabled selected>Select a Major</option>" +
      "<option value='Applied Computer Science'>Applied Computer Science</option>" +
      "<option value='Computer Game Design and Development'>Computer Game Design and Development</option>" +
      "<option value='Computer Science'>Computer Science</option>" +
      "<option value='Information Technology (BAS)'>Information Technology (BAS)</option>" +
      "<option value='Information Technology (BS)'>Information Technology (BS)</option>" +
      "<option value='Software Engineering'>Software Engineering</option>" +
      "<option value='Analytics and Data Science'>Analytics and Data Science</option></select></td>" +
      "<td><select name='stu_lvl[]' required><option value='' disabled selected>Degree Level</option>" +
      "<option value='Bachelor of Science'>Bachelor of Science</option>" +
      "<option value='Master of Science'>Master of Science</option>" +
      "<option value='Doctor of Philosophy'>Doctor of Philosophy</option></select></td>" +
      "<td><input type='button' value='DELETE' onclick=delete_row('stu_row" + $rowno + "')></td></tr>");
  }
  //function to dynamically add empty Contractor row
  function add_c_row() {
    $rowno = $("#contractor_table tr").length;
    $rowno = $rowno + 1;
    $("#contractor_table tr:last").after("<tr id='c_row" + $rowno + "'>" +
      "<td><input type='text' name='c_lname[]' placeholder='Last Name' required></td>" +
      "<td><input type='text' name='c_fname[]' placeholder='First Name' required></td>" +
      "<td><input type='text' name='c_org[]' placeholder='Organization' required></td>" +
      "<td><input type='email' name='c_email[]' placeholder='Email' required></td>" +
      "<td><input type='text' name='c_phone[]' placeholder='Phone'></td>" +
      "<td><input type='date' name='c_start[]' required></td>" +
      "<td><input type='date' name='c_end[]' required></td>" +
      "<td><input type='text' name='c_title[]' placeholder='Title'></td>" +
      "<td><input type='button' value='DELETE' onclick=delete_row('c_row" + $rowno + "')></td></tr>");
  }
</script>
<!--Add in header from pmo_functions.php and insert the title of this page, "Update Project"-->
<?=template_header('Update Project')?>

<body
  onload="checkProjectCategory(); addHeader('faculty_table', 'f_row0'); addHeader('staff_table', 'sta_row0'); addHeader('student_table', 'stu_row0'); addHeader('contractor_table', 'c_row0');">


  <!--Start of container for Update Project section-->
  <div class="jumbotron">
    <!--In the heading, pull up the ID number and Title of the project selected for updating-->
    <h1>Update <?=$project['project_category']?> Project # <?=$project['project_id']?> - <?=$project['project_title']?>
    </h1>
    <a class="btn btn-outline-primary btn-sm" href="get_project.php" role="button">Cancel Update</a>
    <!--Link this form's actions to this file, update_project.php-->
    <form action="update_project.php?project_id=<?=$project['project_id']?>" method="post" autocomplete="off">
      <div class="row">
        <div class="card col-xl-4 col-lg-6 col-md-12">
          <div class="card-header">
            <h2>Section 1 - General Project Information</h2>
          </div>
          <div class="card-body">
            <blockquote class="blockquote mb-0">
              <div class="row">
                <div class="form-group col-lg-6">
                  <label for="project_category">Project Category :</label>
                  <select class="form-control" onchange="checkProjectCategory();" id="project_category"
                    name="project_category" required>
                    <option value="" disabled selected>Select a Category</option>
                    <option <?php if($project['project_category']=="Capstone"){echo "selected";}?>>Capstone</option>
                    <option <?php if($project['project_category']=="Contract for Hire"){echo "selected";}?>>Contract for
                      Hire</option>
                    <option <?php if($project['project_category']=="Research"){echo "selected";}?>>Research</option>
                  </select>
                </div>
                <div class="form-group col-lg-6">

                  <label for="organization_name">Organization Name :</label>
                  <input class="form-control" type="text" name="organization_name"
                    placeholder="ex./ Kennesaw State University" value="<?=$project['organization_name']?> "
                    id="organization_name" required>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-lg-6">
                  <label for="project_title">Project Title :</label>
                  <input type="text" class="form-control" name="project_title" placeholder="ex./ PMO Capstone"
                    value="<?=$project['project_title']?>" id="project_title" required>
                </div>
                <div class="form-group col-lg-6">
                  <label for="ksu_department">KSU Department :</label>
                  <select class="form-control" id="ksu_department" name="ksu_department" required>
                    <option value="" disabled selected>Select KSU Department</option>
                    <option <?php if($project['ksu_department']=="Analytics and Data Science"){echo "selected";}?>>
                      Analytics and Data Science</option>
                    <option <?php if($project['ksu_department']=="Computer Science"){echo "selected";}?>>Computer
                      Science
                    </option>
                    <option <?php if($project['ksu_department']=="Information Technology"){echo "selected";}?>>
                      Information
                      Technology</option>
                    <option
                      <?php if($project['ksu_department']=="Software Engineering and Game Development"){echo "selected";}?>>
                      Software Engineering and Game Development</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-xl-4 col-md-6">
                  <label for="priority_level">Priority Level :</label>
                  <select class="form-control" id="priority_level" name="priority_level" required>
                    <option value="" disabled selected>Select a Priority Level :</option>
                    <option <?php if($project['priority_level']=="Low"){echo "selected";}?>>Low</option>
                    <option <?php if($project['priority_level']=="Medium"){echo "selected";}?>>Medium</option>
                    <option <?php if($project['priority_level']=="High"){echo "selected";}?>>High</option>
                  </select>
                </div>
                <div class="form-group col-xl-4 col-md-6">
                  <label for="start_date">Start Date :</label>
                  <input class="form-control" type="date" name="start_date" placeholder="Format: YYYY-MM-DD"
                    value="<?=$project['start_date']?>" id="start_date" required>
                </div>
                <div class="form-group col-xl-4 col-md-6">
                  <label for="end_date">End Date :</label>
                  <input type="date" name="end_date" placeholder="Format: YYYY-MM-DD" value="<?=$project['end_date']?>"
                    id="end_date" required>
                </div>


                <div class="form-group col-xl-4 col-md-6">
                  <label for="funded">Is this project funded ?</label><br />
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" <?php if ($project['funded']=='Yes') echo 'checked="checked"'; ?>
                      type="radio" name="funded" id="yes_1" value="Yes">
                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" <?php if ($project['funded']=='No') echo 'checked="checked"'; ?>
                      type="radio" name="funded" id="no_1" value="No">
                    <label class="form-check-label" for="inlineRadio2">No</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" <?php if ($project['funded']== 'N/A') echo 'checked="checked"'; ?>
                      type="radio" name="funded" id="n/a" value="N/A" checked>
                    <label class="form-check-label" for="inlineRadio3">N/A</label>
                  </div>
                </div>



                <div class="form-group col-xl-4 col-md-6">

                  <label for="total_cost">Total Cost : $</label>
                  <input class="form-control" type="text" name="total_cost" placeholder="Format: 0.00"
                    value="<?=$project['total_cost']?>" id="total_cost" required>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="description">Description :</label>
                  
                    <textarea class="form-control" id="description" maxlength="600" name="description"
                  placeholder="Type up to 600 characters." required rows="3"><?=$project['description']?></textarea>
                </div>
              </div>
            </blockquote>
          </div>
        </div>

        <div class="card col-xl-4 col-lg-6 col-md-12">
          <div class="card-header">
            <h2>Section 2 - Sponsor Information</h2>
          </div>
          <div class="card-body">
            <blockquote class="blockquote mb-0">
              <label for="last_name">Last Name :</label>
              <input class="form-control" type="text" id="last_name" name="last_name" value="<?=$project['last_name']?>"
                required>

              <label for="first_name">First Name :</label>
              <input class="form-control" type="text" id="first_name" name="first_name"
                value="<?=$project['first_name']?>" required>

              <label for="participant_org">Sponsor's Organization Name :</label>
              <input class="form-control" type="text" id="participant_org" name="participant_org"
                value="<?=$project['participant_org']?>" required>

              <label for="email">Email :</label>
              <input class="form-control" type="email" id="email" name="email" value="<?=$project['email']?>" required>

              <label for="phone">Phone Number :</label>
              <input class="form-control" type="text" id="phone" name="phone" value="<?=$project['phone']?>" required>

            </blockquote>
          </div>
        </div>
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
              $('.capstone_fields').prop('required', true);
            } else {
              document.getElementById('capstone_fields').style.display = 'none';
              $('.capstone_fields').prop('required', false);
            }
            if (document.getElementById('project_category').value == 'Contract for Hire') {
              document.getElementById('contract_fields').style.display = '';
              document.getElementById('company_address').disabled = false;
              document.getElementById('first_payment_amt').disabled = false;
              document.getElementById('second_payment_amt').disabled = false;
              $('.contract_fields').prop('required', true);
            } else {
              document.getElementById('contract_fields').style.display = 'none';
              $('.contract_fields').prop('required', false);
            }
            if (document.getElementById('project_category').value == 'Research') {
              document.getElementById('research_fields').style.display = '';
              document.getElementById('topic').disabled = false;
              $('.research_fields').prop('required', true);
            } else {
              document.getElementById('research_fields').style.display = 'none';
              $('.research_fields').prop('required', false);
            }
          }
        </script>
        <!--Beginning of dynamic project category form fields-->

        <!--capstone project fields-->
        <div class="card card col-xl-4 col-lg-6 col-md-12" id="capstone_fields" name="capstone_fields"
          style="display: none">
          <div class="card-header">
            <h2>Section 3 - Capstone Details</h2>
          </div>
          <div class="card-body">
            <blockquote class="blockquote mb-0">
              <!--capstone project fields-->
              <div class="row">
                <div class="form-group col-lg-6">
                  <label for="degree_level" disabled>What is the degree level for this project?</label>
                  <input id="grad" type="radio" name="degree_level" value="1"
                    <?php if (($project['degree_level']) =='1') echo 'checked="checked"'; ?> required disabled />
                  Graduate
                  <input id="undergrad" type="radio" name="degree_level" value="0"
                    <?php if (($project['degree_level']) =='0') echo 'checked="checked"'; ?> disabled /> Undergraduate
                </div>
                <div class="form-group col-lg-6">
                  <label for="skills_needed">Skills Needed :</label>
                  
                    <textarea class="form-control" id="skills_needed" maxlength="600" name="skills_needed"
                  placeholder="Type up to 600 characters." required disabled rows="3"><?=$project['skills_needed']?></textarea>
                </div>
              </div>

              <div class="row">
                <div class="form-group col-lg-6">
                  <label for="milestone_1">Milestone 1 Deliverables :</label>
                  
                    <textarea class="form-control" id="milestone_1" maxlength="600" name="milestone_1"
                  placeholder="Type up to 600 characters." required disabled rows="3"><?=$project['milestone_1'] ?></textarea>
                </div>

                <div class="form-group col-lg-6">
                  <label for="milestone_2">Milestone 2 Deliverables :</label>
                  
                    <textarea class="form-control" id="milestone_2" maxlength="600" name="milestone_2"
                  placeholder="Type up to 600 characters." required disabled rows="3"><?=$project['milestone_2']?></textarea>
                </div>
              </div>

              <div class="row">
                <div class="form-group col-lg-12">
                  <label for="final_deliverables">Final Deliverables :</label>
                  
                    <textarea class="form-control" id="final_deliverables" maxlength="600" name="final_deliverables"
                  placeholder="Type up to 600 characters." required disabled rows="3"><?=$project['final_deliverables']?></textarea>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-lg-12">
                  <label for="student_benefits">How does this project benefit the student ?</label>
                    <textarea class="form-control" id="student_benefits" maxlength="600" name="student_benefits"
                  placeholder="Type up to 600 characters." required disabled rows="3"><?=$project['student_benefits']?></textarea>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-lg-12">
                  <label for="sponsor_benefits">How does this project benefit the sponsor ?</label>
                    <textarea class="form-control" id="sponsor_benefits" maxlength="600" name="sponsor_benefits"
                  placeholder="Type up to 600 characters." required disabled rows="3"><?=$project['sponsor_benefits']?></textarea>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-lg-12">
                  <label for="company_provides">What will the company provide for the student ?</label>
                    <textarea class="form-control" id="company_provides" maxlength="600" name="company_provides"
                  placeholder="Type up to 600 characters." required disabled rows="3"><?=$project['company_provides']?></textarea>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-xl-4 col-md-6">
                  <label for="nda_or_mou" disabled>Will this project require a NDA or MOU ?</label>
                  <input id="yes_2" type="radio" name="nda_or_mou" value="1"
                    <?php if (($project['nda_or_mou']) =='1') echo 'checked="checked"'; ?> required disabled /> Yes
                
                <input id="no_2" type="radio" name="nda_or_mou" value="0"
                  <?php if (($project['nda_or_mou']) =='0') echo 'checked="checked"'; ?> disabled /> No
                  </div>


              <div class="form-group col-xl-4 col-md-6">
                <label for="company_retain" disabled>Does the company wish to retain IP ?</label>
                <input id="yes_3" type="radio" name="company_retain" value="1"
                  <?php if (($project['company_retain']) =='1') echo 'checked="checked"'; ?> required disabled />
                Yes
                <input id="no_3" type="radio" name="company_retain" value="0"
                  <?php if (($project['company_retain'])=='0') echo 'checked="checked"'; ?> disabled /> No
              </div>
              <div class="form-group col-xl-4 col-md-6">
                <label for="work_on_site" disabled>Will this project require students to work on site ?</label>
                <input id="yes_4" type="radio" name="work_on_site" value="1"
                  <?php if (($project['work_on_site'])=='1') echo 'checked="checked"'; ?> required disabled /> Yes
                <input id="no_4" type="radio" name="work_on_site" value="0"
                  <?php if (($project['work_on_site'])=='0') echo 'checked="checked"'; ?> disabled /> No
              </div>
              <div class="form-group col-xl-4 col-md-6">
                <label for="work_sponsor_site" disabled>Will students be required to present at the sponsor’s site
                  ?</label>
                <input id="yes_5" type="radio" name="work_sponsor_site" value="1"
                  <?php if (($project['work_sponsor_site'])=='1') echo 'checked="checked"'; ?> required disabled />
                Yes
                <input id="no_5" type="radio" name="work_sponsor_site" value="0"
                  <?php if (($project['work_sponsor_site']) =='0') echo 'checked="checked"'; ?> disabled /> No
              </div>
              <div class="form-group col-xl-4 col-md-6">
                <label for="on_campus_present" disabled>Would you like to make an on campus presentation the first
                  week of classes ?</label>
                <input id="yes_6" type="radio" name="on_campus_present" value="1"
                  <?php if (($project['on_campus_present'])=='1') echo 'checked="checked"'; ?> required disabled />
                Yes
                <input id="no_6" type="radio" name="on_campus_present" value="0"
                  <?php if (($project['on_campus_present'])=='0') echo 'checked="checked"'; ?> disabled /> No
              </div>

              <div class="form-group col-xl-4 col-md-6">
                <label for="virtual_present" disabled>If you are unavailable for an on campus presentation,would you
                  like to provide a video presentation ?</label>
                <input id="yes_7" type="radio" name="virtual_present" value="1"
                  <?php if (($project['virtual_present'])=='1') echo 'checked="checked"'; ?> required disabled />
                Yes
                <input id="no_7" type="radio" name="virtual_present" value="0"
                  <?php if (($project['virtual_present']) =='0') echo 'checked="checked"'; ?> disabled /> No
              </div>

              <div class="row">
                <div class="form-group col-xl-4 col-md-6">
                  <label for="num_of_teams">How many student teams are you interested in sponsoring ?</label>
                  <select class="form-control" disabled id="num_of_teams" name="num_of_teams" class="capstone_fields"
                    required>
                    <option value="" disabled selected>Make Selection</option>
                    <option <?php if(($project['num_of_teams'])=="1"){echo "selected";}?>>1</option>
                    <option <?php if(($project['num_of_teams'])=="2"){echo "selected";}?>>2</option>
                    <option <?php if(($project['num_of_teams'])=="3"){echo "selected";}?>>3</option>
                  </select>
                </div>
                <div class="form-group col-lg-6">
                  <label for="availability">Please describe your availability :</label>
                    <textarea class="form-control" id="availability" maxlength="600" name="availability"
                  placeholder="Type up to 600 characters." required disabled rows="3"><?=$project['availability']?></textarea>
                </div>
              </div>
            </blockquote>
          </div>
        </div>



        <!--research project fields-->
        <div class="card card col-xl-4 col-lg-6 col-md-12" id="research_fields" name="research_fields"
          style="display: none">
          <div class="card-header">
            <h2>Section 3 - Research Details</h2>
          </div>
          <div class="card-body">
            <blockquote class="blockquote mb-0">


              <div class="form-group col-lg-12">
                <label for="topic">Topic :</label>
                  <textarea class="form-control research_fields" id="topic" maxlength="600" name="topic"
                placeholder="Type up to 600 characters." required disabled rows="3"><?=$project['topic']?></textarea>
              </div>
            </blockquote>
          </div>
        </div>

        <!--contract project fields-->
        <div class="card card col-xl-4 col-lg-6 col-md-12" id="contract_fields" name="contract_fields"
          style="display: none">
          <div class="card-header">
            <h2>Section 3 - Contract for Hire Details</h2>
          </div>
          <div class="card-body">
            <blockquote class="blockquote mb-0">

              <div class="row">
                <div class="form-group col-lg-12">
                  <label for="company_address">Company Address :</label>
                  
                    <textarea class="form-control contract_fields" id="company_address" maxlength="600"
                  name="company_address" placeholder="Type up to 600 characters." rows="3" required disabled><?=$project['company_address']?></textarea>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-lg-6">
                  <label for="first_payment_amt">First Payment Amount :</label>
                  <input class="form-control" type="text" name="first_payment_amt" class="contract_fields"
                    value="<?=$project['first_payment_amt']?>" id="first_payment_amt" required disabled>
                </div>
                <div class="form-group col-lg-6">
                  <label for="second_payment_amt">Second Payment Amount :</label>
                  <input class="form-control" type="text" name="second_payment_amt" class="contract_fields"
                    value="<?=$project['second_payment_amt']?>" id="second_payment_amt" required disabled>
                </div>
              </div>
            </blockquote>
          </div>
        </div>
        <!--End of dynamic project category form fields-->

        <!--hidden input to store comma seperated list of participant IDs that are on form when it is submitted-->
        <?php
        print '<input type="hidden" name="all_participant_ids" value="'. implode(',', $participantList) .'">';
        ?>
        <div class="card col-sm-12">
          <div class="card-header">
            <h2>Optional - Add Project Participants</h2>
          </div>
          <div class="card-body">
            <blockquote class="blockquote mb-0">
              <table class="table-responsive table-striped table-sm" id="faculty_table" align=center>
                <tr id="f_row0" style="display: none;">
                  <th>Last Name</th>
                  <th>First Name</th>
                  <th>Organization</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Department</th>
                  <th>Title</th>
                </tr>
                <!--Adds the rows of the already existing faculty members-->
                <?php
            $departments = ['Analytics and Data Science','Computer Science','Information Technology',
                            'Software Engineering and Game Development'];
            $i = 1;
            if(isset($other_participants['Faculty'])) {
              foreach($other_participants['Faculty'] as $faculty) {
                $stmt = $conn->prepare('SELECT * FROM faculty_and_staff
                                        WHERE participant_id = ?');
                $stmt->execute([$faculty['participant_id']]);
                $faculty_and_staff = $stmt->fetch(PDO::FETCH_ASSOC);
                $htmlFaculty = '<tr id="f_row'.$i.'"><input type="hidden" name="f_participantid[]" value="'.$faculty['participant_id'].'">
                <td><input type="text" name="f_lname[]" placeholder="Last Name" value="'.$faculty['last_name'].'" required></td>
                <td><input type="text" name="f_fname[]" placeholder="First Name" value="'.$faculty['first_name'].'" required></td>
                <td><input type="text" name="f_org[]" placeholder="Organization" value="'.$faculty['participant_org'].'" required></td>
                <td><input type="email" name="f_email[]" placeholder="Email" value="'.$faculty['email'].'" required></td>
                <td><input type="text" name="f_phone[]" placeholder="Phone"  value="'.$faculty['phone'].'">';
                $htmlFaculty .= '<td><select name="f_dept[]" required>';
                foreach($departments as $department) {
                  if ($department == $faculty_and_staff['department']) {
                      $htmlFaculty .= '<option value="'.$department.'" selected>'.$department.'</option>';
                  } else {
                      $htmlFaculty .= '<option value="'.$department.'">'.$department.'</option>';
                  }
                }
                $htmlFaculty .= '</select></td>';
                $htmlFaculty .= '<td><input type="text" name="f_title[]" placeholder="Title" value="'.$faculty_and_staff['title'].'"></td>
                <td><input type="button" value="DELETE" onclick=delete_row("f_row'.$i.'") /></td></tr>';
                print($htmlFaculty);
                $i++;
              }
            }
          ?>
              </table>
              <input type="button" onclick="add_f_row(); addHeader('faculty_table', 'f_row0')" value="ADD FACULTY">
              <h3>Staff</h3>
              <table class="table-responsive table-striped table-sm" id="staff_table" align=center>
                <tr id="sta_row0" style="display: none;">
                  <th>Last Name</th>
                  <th>First Name</th>
                  <th>Organization</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Department</th>
                  <th>Title</th>
                </tr>
                <!--Adds the rows of the already existing staff members in the project.-->
                <?php
              $i = 1;
              if(isset($other_participants['Staff'])) {
                foreach($other_participants['Staff'] as $staff) {
                  $stmt = $conn->prepare('SELECT * FROM faculty_and_staff
                                          WHERE participant_id = ?');
                  $stmt->execute([$staff['participant_id']]);
                  $faculty_and_staff = $stmt->fetch(PDO::FETCH_ASSOC);
                  $htmlStaff = '<tr id="sta_row'.$i.'"><input type="hidden" name="sta_participantid[]" value="'.$staff['participant_id'].'">
                  <td><input type="text" name="sta_lname[]" placeholder="Last Name" value="'.$staff['last_name'].'" required></td>
                  <td><input type="text" name="sta_fname[]" placeholder="First Name" value="'.$staff['first_name'].'" required></td>
                  <td><input type="text" name="sta_org[]" placeholder="Organization" value="'.$staff['participant_org'].'" required></td>
                  <td><input type="email" name="sta_email[]" placeholder="Email" value="'.$staff['email'].'" required></td>
                  <td><input type="text" name="sta_phone[]" placeholder="Phone" value="'.$staff['phone'].'">';
                  $htmlStaff .= '<td><select name="sta_dept[]" required>';
                  foreach($departments as $department) {
                    if ($department == $faculty_and_staff['department']) {
                        $htmlStaff .= '<option value="'.$department.'" selected>'.$department.'</option>';
                    } else {
                        $htmlStaff .= '<option value="'.$department.'">'.$department.'</option>';
                    }
                  }
                  $htmlStaff.= '</select></td>';
                  $htmlStaff .='<td><input type="text" name="sta_title[]" placeholder="Title" value="'.$faculty_and_staff['title'].'"></td>
                  <td><input type="button" value="DELETE" onclick=delete_row("sta_row'.$i.'") /></td></tr>';
                  print($htmlStaff);
                  $i++;
                }
              }
            ?>
              </table>
              <input type="button" onclick="add_sta_row(); addHeader('staff_table', 'sta_row0')" value="ADD STAFF">
              <h3>Students</h3>
              <table class="table-responsive table-striped table-sm" id="student_table" align=center>
                <tr id="stu_row0" style="display: none;">
                  <th>Last Name</th>
                  <th>First Name</th>
                  <th>Organization</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Major</th>
                  <th>Degree Level</th>
                </tr>
                <!--Adds the rows of the already existing students in the project.-->
                <?php
              $majors = ['Applied Computer Science','Computer Game Design and Development', 'Computer Science',
              'Information Technology (BAS)','Information Technology (BS)','Software Engineering','Analytics and Data Science'];
              $degreeLevels = ['Bachelor of Science','Master of Science','Doctor of Philosophy'];
              $i = 1;
              if(isset($other_participants['Student'])) {
                foreach($other_participants['Student'] as $student) {
                  $stmt = $conn->prepare('SELECT * FROM student
                                          WHERE participant_id = ?');
                  $stmt->execute([$student['participant_id']]);
                  $major_degree = $stmt->fetch(PDO::FETCH_ASSOC);
                  $htmlStudents = '<tr id="stu_row'.$i.'"><input type="hidden" name="stu_participantid[]" value="'.$student['participant_id'].'">
                  <td><input type="text" name="stu_lname[]" placeholder="Last Name" value="'.$student['last_name'].'" required></td>
                  <td><input type="text" name="stu_fname[]" placeholder="First Name" value="'.$student['first_name'].'" required></td>
                  <td><input type="text" name="stu_org[]" placeholder="Organization" value="'.$student['participant_org'].'" required></td>
                  <td><input type="email" name="stu_email[]" placeholder="Email" value="'.$student['email'].'" required></td>
                  <td><input type="text" name="stu_phone[]" placeholder="Phone" value="'.$student['phone'].'">';
                  $htmlStudents .= '<td><select name="major[]" required>';
                  foreach($majors as $maj) {
                    if ($maj == $major_degree['major']) {
                        $htmlStudents .= '<option value="'.$maj.'" selected>'.$maj.'</option>';
                    } else {
                        $htmlStudents .= '<option value="'.$maj.'">'.$maj.'</option>';
                    }
                  }
                  $htmlStudents.= '</select></td>';
                  $htmlStudents .= '<td><select name="stu_lvl[]" required>';
                  foreach($degreeLevels as $lvl) {
                    if ($lvl == $major_degree['degree_level']) {
                        $htmlStudents .= '<option value="'.$lvl.'" selected>'.$lvl.'</option>';
                    } else {
                        $htmlStudents .= '<option value="'.$lvl.'">'.$lvl.'</option>';
                    }
                  }
                  $htmlStudents.= '</select></td>';
                  $htmlStudents .= '<td><input type="button" value="DELETE" onclick=delete_row("stu_row'.$i.'")></td></tr>';
                  print($htmlStudents);
                  $i++;
                }
              }
            ?>
              </table>
              <input type="button" onclick="add_stu_row(); addHeader('student_table', 'stu_row0')" value="ADD STUDENT">
              <h3>Contractors</h3>
              <table class="table-responsive table-striped table-sm" id="contractor_table" align=center>
                <tr id="c_row0" style="display: none;">
                  <th>Last Name</th>
                  <th>First Name</th>
                  <th>Organization</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Contract Start</th>
                  <th>Contract End</th>
                  <th>Title</th>
                </tr>
                <!--Adds the rows of the already existing contractors in the project.-->
                <?php
              $i = 1;
              if(isset($other_participants['Contractor'])) {
                foreach($other_participants['Contractor'] as $contractor) {
                  $stmt = $conn->prepare('SELECT * FROM contractor
                                          WHERE participant_id = ?');
                  $stmt->execute([$contractor['participant_id']]);
                  $contractor_dates_title = $stmt->fetch(PDO::FETCH_ASSOC);
                  print('<tr id="c_row'.$i.'"><input type="hidden" name="c_participantid[]" value="'.$contractor['participant_id'].'">
                  <td><input type="text" name="c_lname[]" placeholder="Last Name" value="'.$contractor['last_name'].'" required></td>
                  <td><input type="text" name="c_fname[]" placeholder="First Name" value="'.$contractor['first_name'].'" required></td>
                  <td><input type="text" name="c_org[]" placeholder="Organization" value="'.$contractor['participant_org'].'" required></td>
                  <td><input type="email" name="c_email[]" placeholder="Email" value="'.$contractor['email'].'" required></td>
                  <td><input type="text" name="c_phone[]" placeholder="Phone" value="'.$contractor['phone'].'"></td>
                  <td><input type="date" name="c_start[]" value="'.$contractor_dates_title['contract_start_date'].'" required></td>
                  <td><input type="date" name="c_end[]" value="'.$contractor_dates_title['contract_end_date'].'" required></td>
                  <td><input type="text" name="c_title[]" placeholder="Title" value="'.$contractor_dates_title['title'].'"></td>
                  <td><input type="button" value="DELETE" onclick=delete_row("c_row'.$i.'")></td></tr>');
                  $i++;
                }
              }
            ?>
              </table>
              <input type="button" onclick="add_c_row(); addHeader('contractor_table', 'c_row0')"
                value="ADD CONTRACTOR">
              <!--Approval Status with Admin Permission only-->
              <h2>Admin Use Only</h2>
              <!--End of dynamic project category form fields-->
              <label for="approval">Approval Status :</label>
              <input id="approved" type="radio" name="approval" value="Approved"
                <?php if ($project['approval']=='Approved') echo 'checked="checked"'; ?> /> Approved
              <input id="disapproved" type="radio" name="approval" value="Disapproved"
                <?php if ($project['approval']=='Disapproved') echo 'checked="checked"'; ?> /> Disapproved
              <input id="pending" type="radio" name="approval" value="Pending"
                <?php if ($project['approval']=='Pending') echo 'checked="checked"'; ?> /> Pending

              <input type="submit" value="Update">
            </blockquote>
          </div>
        </div>
    </form>
    <!--end of update project section container-->
    <!--Add in footer from pmo_functions.php-->
</body>
<?=template_footer()?>
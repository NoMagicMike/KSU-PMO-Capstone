<?php
// Report all errors
error_reporting(E_ALL);
// Initialize the session
session_start();
// Include the pmo_functions.php file to add header, footer, and navbar
require 'pmo_functions.php';
// Check if the project_id exists
if (isset($_GET['project_id'])) {
    // Get the specified project from the project table
    $conn = pdo_connect_mysql();
    $stmt = $conn->prepare('SELECT * FROM project
                            INNER JOIN project_participant
                            ON project.project_id = project_participant.project_id
                            WHERE project_participant.participant_category = "Sponsor"
                            AND project.project_id LIKE ?');
    $stmt->execute([$_GET['project_id']]);
    $project = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$project) {
        die ('Project doesn\'t exist with that ID!');
    }
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
        $stmt_2 = $conn->prepare('SELECT * FROM capstone_project
                                  WHERE project_id = ?');
        $stmt_2->execute([$_GET['project_id']]);
        $ca_project = $stmt_2->fetch(PDO::FETCH_ASSOC);
        if (!$ca_project) {
            die ('Project doesn\'t exist with that ID!');
        }
        $project = array_merge($project, $ca_project);
        break;
      case "Contract for Hire" :
        $stmt_3 = $conn->prepare('SELECT * FROM contract_for_hire
                                  WHERE project_id = ?');
        $stmt_3->execute([$_GET['project_id']]);
        $contract = $stmt_3->fetch(PDO::FETCH_ASSOC);
        if (!$contract) {
            die ('Project doesn\'t exist with that ID!');
        }
        $project = array_merge($project, $contract);
        break;
      case "Research" :
        $stmt_4 = $conn->prepare('SELECT * FROM research_project
                                  WHERE project_id = ?');
        $stmt_4->execute([$_GET['project_id']]);
        $research = $stmt_4->fetch(PDO::FETCH_ASSOC);
        if (!$research) {
            die ('Project doesn\'t exist with that ID!');
        }
        $project = array_merge($project,$research);
        break;
    }
}
else {
    die ('No ID specified!');
}
?>
<!--javascript for dynamic project category form fields. This function controls which following fields are displayed
 based on this project's value for "Project Category"-->
<script>
  function checkProjectCategory() {
    if (document.getElementById('project_category').value == 'Capstone') {
      document.getElementById('capstone_fields').style.display = '';
    } else {
      document.getElementById('capstone_fields').style.display = 'none';
    }
    if (document.getElementById('project_category').value == 'Contract for Hire') {
      document.getElementById('contract_fields').style.display = '';
    } else {
      document.getElementById('contract_fields').style.display = 'none';
    }
    if (document.getElementById('project_category').value == 'Research') {
      document.getElementById('research_fields').style.display = '';
    } else {
      document.getElementById('research_fields').style.display = 'none';
    }
  }
</script>
<!--Add in header from pmo_functions.php and insert the title of this page, "Update Project"-->
<?=template_header('View Project')?>

<body onload="checkProjectCategory();">
  <!--Start of container for Update Project section-->
  <div class="jumbotron">
    <!--In the heading, pull up the category, ID number,  and title of the project selected for updating-->
    <h1><?=$project['project_category']?> Project # <?=$project['project_id']?> - <?=$project['project_title']?></h1>
    <a class="btn btn-outline-primary btn-sm" href="get_project.php" role="button">Projects List</a>
    <!--Link this form's actions to this file, update_project.php-->
    <form action="update_project.php?project_id=<?=$project['project_id']?>" method="post">
      <fieldset disabled>
        <div class="row">
          <!--Link this form's actions to this file, create_project.php-->

          <div class="card col-xl-4 col-lg-6 col-md-12">
            <div class="card-header">
              <h2>Section 1 - General Project Information</h2>
            </div>
            <div class="card-body">
              <blockquote class="blockquote mb-0">
                <div class="row">
                  <div class="form-group col-lg-6">
                    <label for="project_category">Project Category :</label>
                    <input type="text" class="form-control" value="<?=$project['project_category']?>"
                      id="project_category">

                  </div>
                  <div class="form-group col-lg-6">
                    <label for="organization_name">Organization Name :</label>
                    <input type="text" class="form-control" value="<?=$project['organization_name']?> "
                      id="organization_name" name="organization_name">
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-lg-6">
                    <label for="project_title">Project Title :</label>
                    <input type="text" class="form-control" id="project_title" name="project_title"
                      value="<?=$project['project_title']?>">
                  </div>
                  <div class="form-group col-lg-6">
                    <label for="ksu_department">KSU Department :</label>
                    <input type="text" id="ksu_department" class="form-control" name="ksu_department"
                      value="<?=$project['ksu_department']?>">
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-xl-4 col-md-6">
                    <label for="priority_level">Priority Level :</label>
                    <input type="text" class="form-control" id="priority_level" name="priority_level"
                      value="<?=$project['priority_level']?>">
                  </div>
                  <div class="form-group col-xl-4 col-md-6">
                    <label for="start_date">Start Date :</label>
                    <input type="date" class="form-control" id="start_date" name="start_date"
                      value="<?=$project['start_date']?>">
                    <br />
                  </div>
                  <div class="form-group col-xl-4 col-md-6">
                    <label for="end_date">End Date :</label>
                    <input type="date" class="form-control" id="end_date" name="end_date"
                      value="<?=$project['end_date']?>">
                  </div>



                  <div class="form-group col-xl-4 col-md-6">
                    <label for="funded">Is this project funded ?</label><br />
                    <input type="text" class="form-control" id="funded" name="funded" value="<?=$project['funded']?>">
                  </div>
                  <div class="form-group col-xl-4 col-md-6">
                    <label for="total_cost">Total Cost : $</label>
                    <input class="form-control" value="<?=$project['total_cost']?>" type="text" id="total_cost"
                      name="total_cost">

                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="description">Description :</label>
                    <textarea class="form-control" id="description" maxlength="600" name="description"
                      rows="3"><?=$project['description']?></textarea>
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
                <input class="form-control" type="text" id="last_name" name="last_name"
                  value="<?=$project['last_name']?>">
                <br />
                <label for="first_name">First Name :</label>
                <input class="form-control" type="text" id="first_name" name="first_name"
                  value="<?=$project['first_name']?>">
                <br />
                <label for="participant_org">Sponsor's Organization Name :</label>
                <input class="form-control" type="text" id="participant_org" name="participant_org"
                  value="<?=$project['participant_org']?>">
                <br />
                <label for="email">Email :</label>
                <input class="form-control" type="email" id="email" name="email" value="<?=$project['email']?>">
                <br />
                <label for="phone">Phone Number :</label>
                <input class="form-control" type="text" id="phone" name="phone" value="<?=$project['phone']?>">
                <br />
              </blockquote>
            </div>
          </div>


          <!--Beginning of dynamic project category form fields-->
          <!--Capstone project fields-->
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
                    <label for="degree_level" disabled>Degree Level</label>
                    <input type="text" id="grad" name="degree_level" class="form-control"
                      value="<?=$project['degree_level'] ? 'Graduate' : 'Undergraduate'?>">
                  </div>

                  <div class="form-group col-lg-6">
                    <label for="skills_needed">Skills Needed :</label>
                    <textarea class="form-control" id="skills_needed" maxlength="600" name="skills_needed"
                      rows="3"><?=$project['skills_needed']?></textarea>
                  </div>


                </div>

                <div class="row">
                  <div class="form-group col-lg-6">
                    <label for="milestone_1">Milestone 1 Deliverables :</label>
                    <textarea class="form-control" id="milestone_1" maxlength="600" name="milestone_1" required disabled
                      rows="3"><?=$project['milestone_1']?></textarea>
                  </div>

                  <div class="form-group col-lg-6">
                    <label for="milestone_2">Milestone 2 Deliverables :</label>
                    <textarea class="form-control" id="milestone_2" maxlength="600" name="milestone_2"
                      rows="3"> <?=$project['milestone_2']?></textarea>
                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-lg-12">
                    <label for="final_deliverables">Final Deliverables :</label>
                    <textarea class="form-control" id="final_deliverables" maxlength="600" name="final_deliverables"
                      rows="3"><?=$project['final_deliverables']?></textarea>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-lg-12">
                    <label for="student_benefits">How does this project benefit the student ?</label>
                    <textarea class="form-control" id="student_benefits" maxlength="600" name="student_benefits"
                      rows="3"><?=$project['student_benefits']?></textarea>
                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-lg-12">
                    <label for="sponsor_benefits">How does this project benefit the sponsor ?</label>
                    <textarea class="form-control" id="sponsor_benefits" maxlength="600" name="sponsor_benefits"
                      rows="3"><?=$project['sponsor_benefits']?></textarea>
                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-lg-12">
                    <label for="company_provides">What will the company provide for the student ?</label>
                    <textarea class="form-control" id="company_provides" maxlength="600" name="company_provides"
                      rows="3"><?=$project['company_provides']?></textarea>
                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-xl-4 col-md-6">
                    <label for="nda_or_mou">Will this project require a NDA or MOU ?</label>
                    <input type="text" name="nda_or_mou" class="form-control"
                      value="<?=$project['nda_or_mou'] ? 'Yes' : 'No'?>" id="nda_or_mou">


                  </div>

                  <div class="form-group col-xl-4 col-md-6">
                    <label for="company_retain">Does the company wish to retain IP ?</label>
                    <input type="text" name="company_retain" class="form-control"
                      value="<?=$project['company_retain'] ? 'Yes' : 'No'?>" id="company_retain">
                  </div>

                  <div class="form-group col-xl-4 col-md-6">
                    <label for="work_on_site">Will this project require students to work on site ?</label>
                    <input type="text" name="work_on_site" class="form-control"
                      value="<?=$project['work_on_site'] ? 'Yes' : 'No'?>" id="work_on_site">
                  </div>

                  <div class="form-group col-xl-4 col-md-6">
                    <label for="work_sponsor_site">Will students be required to present at the sponsor’s site ?</label>
                    <input type="text" name="work_sponsor_site" class="form-control"
                      value="<?=$project['work_sponsor_site'] ? 'Yes' : 'No'?>" id="work_sponsor_site">
                  </div>

                  <div class="form-group col-xl-4 col-md-6">
                    <label for="on_campus_present">Would you like to make an on campus presentation the first week of
                      classes
                      ?</label>
                    <input type="text" name="on_campus_present" class="form-control"
                      value="<?=$project['on_campus_present'] ? 'Yes' : 'No'?>" id="on_campus_present">
                  </div>

                  <div class="form-group col-xl-4 col-md-6">
                    <label for="virtual_present">If you are unavailable for an on campus presentation,would you like to
                      provide a
                      video presentation ?</label>
                    <input type="text" name="virtual_present" class="form-control"
                      value="<?=$project['virtual_present'] ? 'Yes' : 'No'?>" id="virtual_present">
                  </div>

                </div>
                <div class="row">
                  <div class="form-group col-xl-4 col-md-6">
                    <label for="num_of_teams">How many student teams are you interested in sponsoring ?</label>
                    <input type="text" name="num_of_teams" class="form-control" value="<?=$project['num_of_teams']?>"
                      id="num_of_teams">
                  </div>
                  <div class="form-group col-xl-4 col-md-6">
                    <label for="availability">Please describe your availability :</label>
                    <textarea class="form-control" id="availability" maxlength="600" name="availability"
                      rows="3"><?=$project['availability']?></textarea>
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
                  <label for="topic">Research Topic :</label>
                  <textarea class="form-control research_fields" id="topic" maxlength="600" name="topic"
                    rows="3"><?=$project['topic']?></textarea>
                </div>


              </blockquote>
            </div>
          </div>

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
                      name="company_address" placeholder="Type up to 600 characters." rows="3" required
                      disabled><?=$project['company_address']?></textarea>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-lg-6">
                    <label for="first_payment_amt">First Payment Amount :</label>
                    <input type="text" name="first_payment_amt" class="form-control"
                      value="<?=$project['first_payment_amt']?>" id="first_payment_amt">

                  </div>
                  <div class="form-group col-lg-6">
                    <label for="second_payment_amt">Second Payment Amount :</label>
                    <input type="text" name="second_payment_amt" class="form-control"
                      value="<?=$project['second_payment_amt']?>" id="second_payment_amt">

                  </div>
                </div>
              </blockquote>
            </div>
          </div>

          <!--End of dynamic project category form fields-->
          <div class="card col-sm-12">
            <div class="card-header">
              <h2>Project Participants</h2>
            </div>
            <!--This will only display in the case where there are not any participants to show-->
            <p id="noParticipants">There are not any participants currently added.</p>
            <!-- Faculty table-->
            <!--Faculty table heading and header <th> row will not show if their are not any existing faculty rows-->
            <!-- This will work the same way for all the following participant table sections-->
            <h3 id="f_heading">Faculty</h3>
            <table class="table-responsive table-striped table-sm" id="faculty_table" align=center>
              <tr id="f_row0">
                <th>Last Name</th>
                <th>First Name</th>
                <th>Organization</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Department</th>
                <th>Title</th>
              </tr>
              <!--Adds the rows of the existing faculty members in the project.-->
              <?php
            $i = 1;
            if(isset($other_participants['Faculty'])) {
              foreach($other_participants['Faculty'] as $faculty) {
                $stmt = $conn->prepare('SELECT * FROM faculty_and_staff
                                        WHERE participant_id = ?');
                $stmt->execute([$faculty['participant_id']]);
                $faculty_and_staff = $stmt->fetch(PDO::FETCH_ASSOC);
                print('<tr id="f_row'.$i.'"><input type="hidden" name="f_participantid[]" value="'.$faculty['participant_id'].'">
                <td><input type="text" name="f_lname[]" value="'.$faculty['last_name'].'"></td>
                <td><input type="text" name="f_fname[]" value="'.$faculty['first_name'].'"></td>
                <td><input type="text" name="f_org[]" value="'.$faculty['participant_org'].'"></td>
                <td><input type="text" name="f_email[]" value="'.$faculty['email'].'"></td>
                <td><input type="text" name="f_phone[]" value="'.$faculty['phone'].'"></td>
                <td><input type="text" name="f_dept[]" value="'.$faculty_and_staff['department'].'"></td>
                <td><input type="text" name="f_title[]" value="'.$faculty_and_staff['title'].'"></td></tr>');
                $i++;
              }
            }
          ?>
            </table>
            <!--script to add heading and table header if there is one or more rows present-->
            <script>
              if ($("#faculty_table tr").length <= 1) {
                document.getElementById('f_heading').style.display = 'none';
                document.getElementById('f_row0').style.display = 'none';
              } else if ($("#faculty_table tr").length > 1) {
                document.getElementById('f_heading').style.display = '';
                document.getElementById('f_row0').style.display = '';
              }
            </script>
            <!-- Staff table-->
            <h3 id="sta_heading">Staff</h3>
            <table class="table-responsive table-striped table-sm" id="staff_table" align=center>
              <tr id="sta_row0">
                <th>Last Name</th>
                <th>First Name</th>
                <th>Organization</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Department</th>
                <th>Title</th>
              </tr>
              <!--Adds the rows of the existing staff members in the project.-->
              <?php
              $i = 1;
              if(isset($other_participants['Staff'])) {
                foreach($other_participants['Staff'] as $staff) {
                  $stmt = $conn->prepare('SELECT * FROM faculty_and_staff
                                          WHERE participant_id = ?');
                  $stmt->execute([$staff['participant_id']]);
                  $faculty_and_staff = $stmt->fetch(PDO::FETCH_ASSOC);
                  print('<tr id="sta_row'.$i.'"><input type="hidden" name="sta_participantid[]" value="'.$staff['participant_id'].'">
                  <td><input type="text" name="sta_lname[]" value="'.$staff['last_name'].'"></td>
                  <td><input type="text" name="sta_fname[]" value="'.$staff['first_name'].'"></td>
                  <td><input type="text" name="sta_org[]" value="'.$staff['participant_org'].'"></td>
                  <td><input type="text" name="sta_email[]" value="'.$staff['email'].'"></td>
                  <td><input type="text" name="sta_phone[]" value="'.$staff['phone'].'"></td>
                  <td><input type="text" name="sta_dept[]" value="'.$faculty_and_staff['department'].'"></td>
                  <td><input type="text" name="sta_title[]" value="'.$faculty_and_staff['title'].'"></td></tr>');
                  $i++;
                }
              }
            ?>
            </table>
            <script>
              if ($("#staff_table tr").length <= 1) {
                document.getElementById('sta_heading').style.display = 'none';
                document.getElementById('sta_row0').style.display = 'none';
              } else if ($("#staff_table tr").length > 1) {
                document.getElementById('sta_heading').style.display = '';
                document.getElementById('sta_row0').style.display = '';
              }
            </script>
            <!-- Students table-->
            <h3 id="stu_heading">Students</h3>
            <table class="table-responsive table-striped table-sm" id="student_table" align=center>
              <tr id="stu_row0">
                <th>Last Name</th>
                <th>First Name</th>
                <th>Organization</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Major</th>
                <th>Degree Level</th>
              </tr>
              <!--Adds the rows of the existing students in the project.-->
              <?php
              $i = 1;
              if(isset($other_participants['Student'])) {
                foreach($other_participants['Student'] as $student) {
                  $stmt = $conn->prepare('SELECT * FROM student
                                          WHERE participant_id = ?');
                  $stmt->execute([$student['participant_id']]);
                  $major_degree = $stmt->fetch(PDO::FETCH_ASSOC);
                  print('<tr id="stu_row'.$i.'"><input type="hidden" name="stu_participantid[]" value="'.$student['participant_id'].'">
                  <td><input type="text" name="stu_lname[]" value="'.$student['last_name'].'"></td>
                  <td><input type="text" name="stu_fname[]" value="'.$student['first_name'].'"></td>
                  <td><input type="text" name="stu_org[]" value="'.$student['participant_org'].'"></td>
                  <td><input type="text" name="stu_email[]" value="'.$student['email'].'"></td>
                  <td><input type="text" name="stu_phone[]" value="'.$student['phone'].'"></td>
                  <td><input type="text" name="major[]" value="'.$major_degree['major'].'"></td>
                  <td><input type="text" name="stu_lvl[]" value="'.$major_degree['degree_level'].'"></td></tr>');
                  $i++;
                }
              }
            ?>
            </table>
            <script>
              if ($("#student_table tr").length <= 1) {
                document.getElementById('stu_heading').style.display = 'none';
                document.getElementById('stu_row0').style.display = 'none';
              } else if ($("#student_table tr").length > 1) {
                document.getElementById('stu_heading').style.display = '';
                document.getElementById('stu_row0').style.display = '';
              }
            </script>
            <!-- Contractors table-->
            <h3 id="c_heading">Contractors</h3>
            <table class="table-responsive table-striped table-sm" id="contractor_table" align=center>
              <tr id="c_row0">
                <th>Last Name</th>
                <th>First Name</th>
                <th>Organization</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Contract Start</th>
                <th>Contract End</th>
                <th>Title</th>
              </tr>
              <!--Adds the rows of the existing contractors in the project.-->
              <?php
              $i = 1;
              if(isset($other_participants['Contractor'])) {
                foreach($other_participants['Contractor'] as $contractor) {
                  $stmt = $conn->prepare('SELECT * FROM contractor
                                          WHERE participant_id = ?');
                  $stmt->execute([$contractor['participant_id']]);
                  $contractor_dates_title = $stmt->fetch(PDO::FETCH_ASSOC);
                  print('<tr id="c_row'.$i.'"><input type="hidden" name="c_participantid[]" value="'.$contractor['participant_id'].'">
                  <td><input type="text" name="c_lname[]" value="'.$contractor['last_name'].'"></td>
                  <td><input type="text" name="c_fname[]" value="'.$contractor['first_name'].'"></td>
                  <td><input type="text" name="c_org[]" value="'.$contractor['participant_org'].'"></td>
                  <td><input type="text" name="c_email[]" value="'.$contractor['email'].'"></td>
                  <td><input type="text" name="c_phone[]" value="'.$contractor['phone'].'"></td>
                  <td><input type="date" name="c_start[]" value="'.$contractor_dates_title['contract_start_date'].'"></td>
                  <td><input type="date" name="c_end[]" value="'.$contractor_dates_title['contract_end_date'].'"></td>
                  <td><input type="text" name="c_title[]" value="'.$contractor_dates_title['title'].'"></td></tr>');
                  $i++;
                }
              }
            ?>
            </table>
            <script>
              if ($("#contractor_table tr").length <= 1) {
                document.getElementById('c_heading').style.display = 'none';
                document.getElementById('c_row0').style.display = 'none';
              } else if ($("#contractor_table tr").length > 1) {
                document.getElementById('c_heading').style.display = '';
                document.getElementById('c_row0').style.display = '';
              }
            </script>
            <!--This is to display the statement that there are not any participants added, in the case when there are none.-->
            <script>
              if ($("#faculty_table tr").length <= 1 && $("#staff_table tr").length <= 1 && $("#student_table tr")
                .length <=
                1 && $("#contractor_table tr").length <= 1) {
                document.getElementById('noParticipants').style.display = '';
              } else {
                document.getElementById('noParticipants').style.display = 'none';
              }
            </script>
            <div class="row">
              <div class="form-group col-lg-12">
                <h2>Approval Status</h2>
                <!--End of dynamic project category form fields-->
                <input id="approved" type="radio" name="approval" value="Approved"
                  <?php if ($project['approval']=='Approved') echo 'checked="checked"'; ?> /> Approved
                <input id="disapproved" type="radio" name="approval" value="Disapproved"
                  <?php if ($project['approval']=='Disapproved') echo 'checked="checked"'; ?> /> Disapproved
                <input id="pending" type="radio" name="approval" value="Pending"
                  <?php if ($project['approval']=='Pending') echo 'checked="checked"'; ?> /> Pending
                <br />
              </div>
            </div>
          </div>
        </div>
      </fieldset>
    </form>
  </div>
  <!--end of update project section container-->
  <!--Add in footer from pmo_functions.php-->
</body>
<?=template_footer()?>
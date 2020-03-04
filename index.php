<!DOCTYPE html>
<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title></title>
  <!-- Bootstrap References -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>

<body>
  <!-- Start of Navbar -->
  <nav class="navbar navbar-light navbar-expand-lg" style="background-color: #e3f2fd;">
    <a class="navbar-brand" href="index.php">
      <img src="static/KSUBrand.png" width="50" height="50" alt="KSU Logo"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
        </li>
        <?php if(isset($_SESSION['loggedin'])): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Projects
            </a>

            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="add_project_form.html">Add New Project</a>
              <a class="dropdown-item" href="get_project_form.html">View All Projects</a>
              <div class="dropdown-divider"></div>
            </div>
          </li>
        <?php else: ?>
            <!-- If logged out, show nothing in Navbar -->
        <?php endif; ?>

        <li class="nav-item active d-flex justify-content-end">
          <?php if(isset( $_SESSION['loggedin'])): ?>
              <a class="nav-link text-right" href="logout.php">Logout <span class="sr-only">(current)</span></a>
          <?php else: ?>
              <a class="nav-link text-right" href="login.php">Login <span class="sr-only">(current)</span></a>
          <?php endif; ?>

        </li>

    </div>
  </nav>
  <!-- End of Navbar -->
  <!-- Start Jumbotron -->
  <div class="jumbotron">
    <h1 class="display-4">Kennesaw State University</h1>
    <p class="lead">Project Management System</p>
    <hr class="my-4">
    <p>Please use the navigation bar above to view options, or hit the button below to create a new project.</p>
    <a class="btn btn-primary btn-lg" href="add_project_form.html" role="button">New Project</a>
  </div>
</body>

</html>
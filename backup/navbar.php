<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>$title</title>
    <!--link all the pages to the external styling css file, pmo_style.css-->
		<link href="pmo_style.css" rel="stylesheet" type="text/css">
    <!-- fontawesome is used for the icons-->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <!-- Bootstrap References -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </head>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	    <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
	        <ul class="navbar-nav mr-auto">
	          <?php if(isset($_SESSION['loggedin'])): ?>
	            <li class="nav-item active text-nowrap">
	                <a class="nav-link" href="index.php"><i class="fas fa-home"></i> Home<span class="sr-only">(current)</span></a>
	            </li>
	            <li class="nav-item dropdown">
	              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	                Projects
	              </a>

	              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
	                <a class="dropdown-item" href="create_project.php">Add New Project</a>
	                <a class="dropdown-item" href="get_project.php">View All Projects</a>
	                <div class="dropdown-divider"></div>
	              </div>
	    				</li>
	    				<?php if($_SESSION['adminCheck'] == 1): ?>
	    					<li class="nav-item dropdown">
	    	          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    	            Admin Portal
	    	          </a>

	    	          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
	    	            <a class="dropdown-item" href="register.php">Add New Users</a>
	    	            <a class="dropdown-item" href="">Placeholder</a>
	    	            <div class="dropdown-divider"></div>
	    	          </div>
	    					</li>
	    				<?php endif; ?>
	        </ul>
	    </div>
	    <div class="mx-auto order-0">
	        <a class="navbar-brand mx-auto" href="index.php"><img src="static/KSUBrandLong.png" height="50" alt="KSU Logo"></a>
	        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="navbar-toggler-icon"></span>
	        </button>
	    </div>
	    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
	        <ul class="navbar-nav ml-auto text-nowrap">
	          <form class="form-inline my-2 my-lg-0 ">
	            <input class="form-control mr-sm-2" type="search" placeholder="Not Yet Functional :(" aria-label="Search">
	          	<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
	          </form>
	        <?php else: ?>
	            <!-- If logged out, show nothing in Navbar -->
	        <?php endif; ?>
	            <li class="nav-item">
	              <?php if(isset( $_SESSION['loggedin'])): ?>
	                <li class="nav-item dropdown">
	                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	                    Account
	                  </a>

	                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
	                    <a class="dropdown-item" href="logout.php">Logout</a>
	                  </div>
	                </li>
	                  
	              <?php else: ?>
	                  <a class="nav-link text-right" href="login.php">Login <span class="sr-only">(current)</span></a>
	              <?php endif; ?>
	            </li>
	        </ul>
	    </div>
	</nav>
</html>

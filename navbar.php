<head>
	<meta charset="utf-8">
	<!--link all the pages to the external styling css file, pmo_style.css-->
	<link href="pmo_style.css" rel="stylesheet" type="text/css">
	<!-- fontawesome is used for the icons-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	<!-- Bootstrap References -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	</head>
	<nav class="navbar navbar-expand-md navbar-dark bg-dark">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Logo only shows on smaller screens -->
      <a class="navbar-brand d-md-none justify-content-md-center" href="index.php"><img src="static/KSUBrandLong.png" height="50" alt="KSU Logo"></a>
      <!-- Check if user is logged in -->
      <?php if(isset($_SESSION['loggedin'])): ?>
      <div class="collapse navbar-collapse justify-content-between" id="navbarsExample04">
        
        <ul class="navbar-nav">
					
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
						<!-- Check if user is an admin -->
						<?php if($_SESSION['adminCheck'] == 1): ?>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Admin Portal
								</a>

								<div class="dropdown-menu" aria-labelledby="navbarDropdown">
									<a class="dropdown-item" href="add_user.php">Add New Users</a>
									<a class="dropdown-item" href="get_user.php">View All Users</a>
									<div class="dropdown-divider"></div>
								</div>
							</li>
            <?php endif; ?> <!--end of admin check -->
					</ul>
          <?php endif; ?> <!--end of loggedin check -->
          <!-- Logo shows on larger screens in center -->
					<a class="navbar-brand d-none d-md-block" href="index.php"><img src="static/KSUBrandLong.png" height="50" alt="KSU Logo"></a>
        
        
          
          
			    
					<?php if(isset( $_SESSION['loggedin'])): ?>
					<ul class="navbar-nav">
						<form class="form-inline my-2 my-md-0 " action="get_project.php" method="get">
							<input class="form-control mr-sm-2" type="text" name="search" placeholder="Search Projects" aria-label="Search" value="<?=isset($_GET['search']) ? htmlentities($_GET['search'], ENT_QUOTES) : ''?>">
							<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
						</form>
						<li class="nav-item">
								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										Account
									</a>

									<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
										<a class="dropdown-item" href="logout.php">Logout</a>
										<a class="dropdown-item" href="reset_password.php">Reset Password</a>
									</div>
								</li>

						<?php endif; ?>
						</li>
					</ul>
        
				
				
      </div>
    </nav>


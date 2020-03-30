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

      <div class="collapse navbar-collapse justify-content-between" id="navbarsExample04">
				<a class="navbar-brand d-md-none" href="index.php"><img src="static/KSUBrandLong.png" height="50" alt="KSU Logo"></a>
				<?php if(isset($_SESSION['loggedin'])): ?>
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
					   <?php endif; ?>
					</ul>	
        
					
					<?php endif; ?>
					<a class="navbar-brand d-none d-md-block" href="index.php"><img src="static/KSUBrandLong.png" height="50" alt="KSU Logo"></a>
			    
					<?php if(isset( $_SESSION['loggedin'])): ?>
					<ul class="navbar-nav">
						<form class="form-inline my-2 my-md-0">
							<input class="form-control mr-sm-2" type="search" placeholder="Not Yet Functional :(" aria-label="Search">
							<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
						</form>
						<li class="nav-item">
								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										Account
									</a>

									<div class="dropdown-menu" aria-labelledby="navbarDropdown">
										<a class="dropdown-item" href="logout.php">Logout</a>
										<a class="dropdown-item" href="reset_password.php">Reset Password</a>
									</div>
								</li>

						<?php endif; ?>
						</li>
					</ul>
        
				
				
      </div>
    </nav>


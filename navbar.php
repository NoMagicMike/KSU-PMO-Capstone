
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
	    	            <a class="dropdown-item" href="add_user.php">Add New Users</a>
	    	            <a class="dropdown-item" href="get_user.php">View All Users</a>
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
											<a class="dropdown-item" href="reset_password.php">Reset Password</a>
	                  </div>
	                </li>

	              <?php else: ?>
	                  <a class="nav-link text-right" href="login.php">Login <span class="sr-only">(current)</span></a>
	              <?php endif; ?>
	            </li>
	        </ul>
	    </div>
	</nav>


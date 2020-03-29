<?php
// Initialize the session
session_start();
//include the pmo_functions.php file to add header, footer, and navbar
include 'pmo_functions.php';
include 'navbar.php';
//make a connection to the database for these specific tasks
$conn = pdo_connect_mysql();
/* Get the page via GET request (URL param: page), if not enough records exist for there to
be more than one page, default the page to 1*/
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page, default to 5
$records_per_page = isset($_GET['records_per_page']) && (is_numeric($_GET['records_per_page']) || $_GET['records_per_page'] == 'All') ? $_GET['records_per_page'] : 10;
// These are the columns the users can "order by"
$order_by_list = array('user_id', 'username', 'created_at',
'user_admin');
// Get the column the user picks to order by (default to user_id)
$order_by = isset($_GET['order_by']) && in_array($_GET['order_by'], $order_by_list) ? $_GET['order_by'] : 'user_id';
// Sort by ascending or descending if specified, default to ascending
$order_sort = isset($_GET['order_sort']) && $_GET['order_sort'] == 'DESC' ? 'DESC' : 'ASC';
/*When user does a search for specific data, it will retrieve all the records in the database table
that contain the user-specified value, but it will default to only displaying 5 at a time. If the user
then selects "ALL", it will then display all of the records in the database table that contain the value the user
previously specified (on one page)*/
if (isset($_GET['search'])) {
	if ($records_per_page == 'All') {
		// SQL statement to get all records containing the specific search query
		$stmt = $conn->prepare('SELECT * FROM user
							   WHERE user_id LIKE :search_query
								  OR username LIKE :search_query
								  ORDER BY ' . $order_by . ' ' . $order_sort);
		$stmt->bindValue(':search_query', '%' . $_GET['search'] . '%');
	} else {
		/*After the user does a search for records containing specific data, they can navigate back and
		forth between pages of the records that contain the specific data, and also limit the amout of
		these records they want displayed at a time for each page*/
		$stmt = $conn->prepare('SELECT * FROM user
                WHERE user_id LIKE :search_query
                  OR username LIKE :search_query
								   ORDER BY ' . $order_by . ' ' . $order_sort . '
								LIMIT :current_page, :record_per_page');
		$stmt->bindValue(':search_query', '%' . $_GET['search'] . '%');
		$stmt->bindValue(':current_page', ($page-1)*(int)$records_per_page, PDO::PARAM_INT);
		$stmt->bindValue(':record_per_page', (int)$records_per_page, PDO::PARAM_INT);
	}
}
/*If the user did not specify any data to search for and just clicked "All", it will pull up every
 single record contained in the database table on one page*/
else {
	if ($records_per_page == 'All') {
		$stmt = $conn->prepare('SELECT * FROM user ORDER BY ' . $order_by . ' ' . $order_sort);
	}
	/*If the user did not specify any data to search for, they could navigate back and forth through pages
	that contain every single record in the database table. The user can limit the number of records they
	want to have displayed at a time (it will default to 5 at first).*/
	else {
		$stmt = $conn->prepare('SELECT * FROM user ORDER BY ' . $order_by . ' ' . $order_sort . ' LIMIT :current_page, :record_per_page');
		$stmt->bindValue(':current_page', ($page-1)*(int)$records_per_page, PDO::PARAM_INT);
		$stmt->bindValue(':record_per_page', (int)$records_per_page, PDO::PARAM_INT);
	}
}
$stmt->execute();
// Fetch the records to be displayed.
$user = $stmt->fetchAll(PDO::FETCH_ASSOC);
/* Get the total number of records searched that match the specified search criteria, this is so
we can see if needs to have a next and previous button*/
if (isset($_GET['search'])) {
	$stmt = $conn->prepare('SELECT COUNT(*) FROM user
							WHERE user_id LIKE :search_query
							  OR username LIKE :search_query');
	$stmt->bindValue(':search_query', '%' . $_GET['search'] . '%');
	$stmt->execute();
	$num_user = $stmt->fetchColumn();
}
/*If no serch criteria was specified, just count all of the records in the database table
to see if there should be a next and previous button*/
else {
	$num_user = $conn->query('SELECT COUNT(*) FROM user')->fetchColumn();
}
?>
<!--Add in header from pmo_functions.php and insert the title of this page, "Get User"-->
<?=template_header('Get User')?>
<!--beginning of container for the get user section-->
<div class="container">
	<h2>View and Search Users</h2>
	<!--beginning of container for a button that links back to add_user.php,
  (this "Create User" button can be deleted and the navbar could be used instead,
	since that function is available, just thought this could be an option)
	and the custom search bar.-->
	<div>
		<div class="d-inline-block">
			<a class="btn btn-outline-primary btn-sm" href="add_user.php" role="button">Create User</a>
		</div>
		<div class="d-inline-block">
			<form action="get_user.php" method="get">
				<input type="text" name="search" placeholder="Search..." value="<?=isset($_GET['search']) ? htmlentities($_GET['search'], ENT_QUOTES) : ''?>">
			</form>
		</div>
	</div>
	<!--end of container for the add_user.php button link and custom search bar-->
	<!--Beginning of table for records to be displayed-->
	<table>
		    <!--beginning of table column header row-->
				<!--The records are ordered by user_id by default, but if the user clicks the
				column heading i.e. "Title", the records will then be ordered by "Title".-->
        <thead>
            <tr>
							<!--ID column header-->
							<td>
								<a href="get_user.php?page=1&records_per_page=<?=$records_per_page?>&order_by=user_id>&order_sort=<?=$order_sort == 'ASC' ? 'DESC' : 'ASC'?><?=isset($_GET['search']) ? '&search=' . htmlentities($_GET['search'], ENT_QUOTES) : ''?>">
								ID
								<?php if ($order_by == 'user_id'): ?>
								<i class="fas fa-long-arrow-alt-<?=str_replace(array('ASC', 'DESC'), array('up', 'down'), $order_sort)?>"></i>
								<?php endif; ?>
								</a>
			        </td>
							<!--Username column header-->
              <td>
								<a href="get_user.php?page=1&records_per_page=<?=$records_per_page?>&order_by=department&order_sort=<?=$order_sort == 'ASC' ? 'DESC' : 'ASC'?><?=isset($_GET['search']) ? '&search=' . htmlentities($_GET['search'], ENT_QUOTES) : ''?>">
						    Username
								<?php if ($order_by == 'username'): ?>
								<i class="fas fa-long-arrow-alt-<?=str_replace(array('ASC', 'DESC'), array('up', 'down'), $order_sort)?>"></i>
								<?php endif; ?>
								</a>
							</td>
							<!--Start Date column header-->
              <td>
								<a href="get_user.php?page=1&records_per_page=<?=$records_per_page?>&order_by=start_date&order_sort=<?=$order_sort == 'ASC' ? 'DESC' : 'ASC'?><?=isset($_GET['search']) ? '&search=' . htmlentities($_GET['search'], ENT_QUOTES) : ''?>">
						    Creation Date
								<?php if ($order_by == 'created_at'): ?>
								<i class="fas fa-long-arrow-alt-<?=str_replace(array('ASC', 'DESC'), array('up', 'down'), $order_sort)?>"></i>
								<?php endif; ?>
								</a>
              </td>
							<!--Admin column header-->
							<td>
								<a href="get_user.php?page=1&records_per_page=<?=$records_per_page?>&order_by=user_description&order_sort=<?=$order_sort == 'ASC' ? 'DESC' : 'ASC'?><?=isset($_GET['search']) ? '&search=' . htmlentities($_GET['search'], ENT_QUOTES) : ''?>">
						    Admin?
								<?php if ($order_by == 'user_admin'): ?>
								<i class="fas fa-long-arrow-alt-<?=str_replace(array('ASC', 'DESC'), array('up', 'down'), $order_sort)?>"></i>
								<?php endif; ?>
								</a>
							</td>
							<!--Empty cell column header for the column containing the edit/delete icon links-->
              <td></td>
            </tr>
        </thead><!--end of table column header section-->
				<!--Body of table that will populate rows with the values of each field in a record-->
				<tbody>
            <?php foreach ($user as $user): ?>
            <tr>
							  <td><?=$user['user_id']?></td>
                <td><?=$user['username']?></td>
                <td><?=$user['created_at']?></td>
                <td>
									<?php if ($user['user_admin'] == 1){
										echo "Yes";
									} else echo "No";
									?>										
									
								</td>
								<!--Populate the end of each row with icons links that edit and delete each record-->
                <td>
                    <a href="update_user.php?user_id=<?=$user['user_id']?>"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete_user.php?user_id=<?=$user['user_id']?>"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
		<!--End of table for records to be displayed-->
  <!--Beginning of container for the bottom of the get user section-->
	<div>
		<!--Beginning of container for the records per page selections-->
		<div>
			<a href="get_user.php?page=1&records_per_page=10&order_by=<?=$order_by?>&order_sort=<?=$order_sort?><?=isset($_GET['search']) ? '&search=' . htmlentities($_GET['search'], ENT_QUOTES) : ''?>">10</a>
			<a href="get_user.php?page=1&records_per_page=20&order_by=<?=$order_by?>&order_sort=<?=$order_sort?><?=isset($_GET['search']) ? '&search=' . htmlentities($_GET['search'], ENT_QUOTES) : ''?>">20</a>
			<a href="get_user.php?page=1&records_per_page=50&order_by=<?=$order_by?>&order_sort=<?=$order_sort?><?=isset($_GET['search']) ? '&search=' . htmlentities($_GET['search'], ENT_QUOTES) : ''?>">50</a>
			<a href="get_user.php?page=1&records_per_page=100&order_by=<?=$order_by?>&order_sort=<?=$order_sort?><?=isset($_GET['search']) ? '&search=' . htmlentities($_GET['search'], ENT_QUOTES) : ''?>">100</a>
			<a href="get_user.php?page=1&records_per_page=All&order_by=<?=$order_by?>&order_sort=<?=$order_sort?><?=isset($_GET['search']) ? '&search=' . htmlentities($_GET['search'], ENT_QUOTES) : ''?>">All</a>
		</div>
		<!--End of container for the records per page selections-->
		<!--Beginning of container for the pagination
		(displays Page and the page number, and a page navigation arrow the user can
	  click to move page to page).-->
		<div>
			<?php if ($page > 1): ?>
			<a href="get_user.php?page=<?=$page-1?>&records_per_page=<?=$records_per_page?>&order_by=<?=$order_by?>&order_sort=<?=$order_sort?><?=isset($_GET['search']) ? '&search=' . htmlentities($_GET['search'], ENT_QUOTES) : ''?>">
				<i class="fas fa-angle-double-left fa-sm"></i>
			</a>
			<?php endif; ?>
			<!--Beginning of container for "Page" and the page number displayed-->
			<div href="register.php?page=<?=$page?>&records_per_page=<?=$records_per_page?>&order_by=<?=$order_by?>&order_sort=<?=$order_sort?><?=isset($_GET['search']) ? '&search=' . htmlentities($_GET['search'], ENT_QUOTES) : ''?>">
			Page <?=$page?>
			</div>
			<!--End of container for just the page and number displayed-->
			<?php if ($records_per_page != 'All' && $page*$records_per_page < $num_user): ?>
			<a href="get_user.php?page=<?=$page+1?>&records_per_page=<?=$records_per_page?>&order_by=<?=$order_by?>&order_sort=<?=$order_sort?><?=isset($_GET['search']) ? '&search=' . htmlentities($_GET['search'], ENT_QUOTES) : ''?>">
			<i class="fas fa-angle-double-right fa-sm"></i>
			</a>
			<?php endif; ?>
		</div>
		<!--End of container for the pagination-->
	</div>
	<!--End of container for the bottom of the get user section-->
</div>
<!--end of container for the get user section-->
<!--Add in footer from pmo_functions.php-->
<?=template_footer()?>

<?php
ob_start();
$title = "Page List";
$body_id = "page-list";
require_once 'includes/user-auth.php';
require_once 'includes/header.php';

try {
	require_once 'includes/db.php';

	// Query that selects all available pages
	$sql = "SELECT page_id, page_title, page_link, page_header, page_order, page_author FROM a2_pages ORDER BY page_order";

	// Execute and store all returned a2_pages as page
	$cmd = $conn->prepare($sql);
	$cmd->execute();
	$a2_pages = $cmd->fetchAll();

	// Disconnect
	$conn = null;

} catch (Exception $e) {
	// Catch error and store in variable then send to specified email
	// Redirect user to designated error page
	mail('error@mseifried.com', 'A2 Error | page-list.php', $e);
	header('location:error.php');
};
?>

<h1>Add, Edit & Delete Pages</h1>
<p>Add a new page <a href="create-page.php">here</a>.</p>
<table>
	<thead>
		<th>Page ID</th>
		<th>Page Title</th>
		<th>Page Link</th>
		<th>Page Header</th>
		<th>Page Order</th>
		<th>Page Author</th>
		<th>Edit</th>
		<th>Delete</th>
	</thead>
	<tbody>
	<?php
	// Echo data into table for viewing
	foreach ($a2_pages as $page) {
		echo '
			<tr>
				<td>' . $page['page_id'] . '</td>
				<td>' . $page['page_title'] . '</td>
				<td>' . $page['page_link'] . '</td>
				<td>' . $page['page_header'] . '</td>
				<td>' . $page['page_order'] . '</td>
				<td>' . $page['page_author'] . '</td>
				<td><a href="edit-page.php?page_id=' . $page['page_id'] . '">Edit</a></td>
				<!-- Delete button triggers confirmation dialog before initiating delete -->
				<td><a href="delete-page.php?page_id=' . $page['page_id'] . '" onclick="return confirm(\'Are you sure?\');">Delete</a></td>
			</tr>
			';
	};
	?>
	</tbody>
</table>

<?php
require_once 'includes/footer.php';
ob_flush();
?>

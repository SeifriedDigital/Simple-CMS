<?php
ob_start();
$title = "Edit Page";
$body_id = "edit-page";
require_once 'includes/user-auth.php';
require_once 'includes/header.php';

$page_id = $_GET['page_id'];

try {
	// Requires the user to make edits by clicking edit on user-list.php this avoids errors.
	if ((!empty($page_id)) && (is_numeric($page_id))) {

		require_once 'includes/db.php';

		// Get data for selected user
		$sql = "SELECT * FROM a2_pages WHERE page_id = :page_id";
		$cmd = $conn->prepare($sql);
		$cmd->bindParam(':page_id', $page_id, PDO::PARAM_INT);
		$cmd->execute();
		$a2_pages = $cmd->fetchAll();

		// Loop through each column for returned page_id row and bind database data to variables
		foreach ($a2_pages as $page) {
			$page_title = $page['page_title'];
			$page_link = $page['page_link'];
			$page_header = $page['page_header'];
			$page_content = $page['page_content'];
			$page_order = $page['page_order'];
			$page_author = $page['page_author'];
			$page_description = $page['page_description'];
		}

		// Disconnect
		$conn = null;

		echo '
			<form method="post" action="save-page-edit.php">
				<div>
					<input type="number" name="page_id" value="' . $page_id . '" required style="display: none;">
				</div>
				<div>
					<label for="page_title">Page Title:</label>
					<input type="text" name="page_title" value="' . $page_title . '" required>
				</div>
				<div>
					<label for="page_link">Page Link:</label>
					<input type="text" name="page_link" value="' . $page_link . '" required>
				</div>
				<div>
					<label for="page_header">Page Header:</label>
					<input type="text" name="page_header" value="' . $page_header . '" required>
				</div>
				<div>
					<label for="page_content">Page Content:</label>
					<textarea name="page_content" required>' . $page_content . '</textarea>
				</div>
				<div>
					<label for="page_order">Display Order:</label>
					<input type="number" name="page_order" value="' . $page_order . '">
				</div>
				<div>
					<label for="page_author">Author:</label>
					<input type="text" name="page_author" value="' . $page_author . '" required>
				</div>
				<div>
					<label for="page_description">Description:</label>
					<textarea type="text" name="page_description" required>' . $page_description . '</textarea>
				</div>
				<div>
					<button type="submit">Update Page</button>
				</div>
			</form>
			';
	} else {
		echo '<p>You need to access this page by clicking "Edit" on a user found on the <a href="page-list.php">page list</a> admin page.</p>';
	}

} catch (Exception $e) {
	// Catch error and store in variable then send to specified email
	// Redirect user to designated error page
	echo 'Error';
	mail('error@mseifried.com', 'A2 Error | edit-page.php', $e);
	header('location:error.php');
};

require_once 'includes/footer.php';
ob_flush();
?>
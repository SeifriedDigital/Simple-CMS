<?php
ob_start();
$title = 'Update Page';
$body_id = "save-page-edit";
require_once 'includes/user-auth.php';
require_once 'includes/header.php';

try {
	// Store page info into variables
	$page_id = $_POST['page_id'];
	$page_title = $_POST['page_title'];
	$page_link = $_POST['page_link'];
	$page_header = $_POST['page_header'];
	$page_content = $_POST['page_content'];
	$page_order = $_POST['page_order'];
	$page_author = $_POST['page_author'];
	$page_description = $_POST['page_description'];

	// Validation boolean
	$ok = true;

	// Validate the input data
	if (empty($page_title)) {
		echo 'A title is required<br><a href="edit-page.php?page_id=' . $page_id . '">Back</a>';
		$ok = false;
	}

	if (empty($page_link)) {
		echo 'Page link is required<br><a href="edit-page.php?page_id=' . $page_id . '">Back</a>';
		$ok = false;
	}

	if (empty($page_header)) {
		echo 'Header is required<br><a href="edit-page.php?page_id=' . $page_id . '">Back</a>';
		$ok = false;
	}

	if (empty($page_content)) {
		echo 'Content is required<br><a href="edit-page.php?page_id=' . $page_id . '">Back</a>';
		$ok = false;
	}

	if (empty($page_author)) {
		echo 'Author is required<br><a href="edit-page.php?page_id=' . $page_id . '">Back</a>';
		$ok = false;
	}

	if (empty($page_description)) {
		echo 'Description is required<br><a href="edit-page.php?page_id=' . $page_id . '">Back</a>';
		$ok = false;
	}

	if ($ok) {
		// Connect to database if all the above conditions pass
		require 'includes/db.php';

		// Bind updated values to query and update database
		$sql = "UPDATE a2_pages SET page_title = :page_title, page_link = :page_link, page_header = :page_header, page_content = :page_content, page_order = :page_order, page_author = :page_author, page_description = :page_description WHERE page_id = :page_id;";

		// Bind parameters and execute
		$cmd = $conn->prepare($sql);
		$cmd->bindParam(':page_id', $page_id, PDO::PARAM_INT);
		$cmd->bindParam(':page_title', $page_title, PDO::PARAM_STR, 255);
		$cmd->bindParam(':page_link', $page_link, PDO::PARAM_STR, 255);
		$cmd->bindParam(':page_header', $page_header, PDO::PARAM_STR, 255);
		$cmd->bindParam(':page_content', $page_content, PDO::PARAM_STR, 16777215);
		$cmd->bindParam(':page_order', $page_order, PDO::PARAM_INT);
		$cmd->bindParam(':page_author', $page_author, PDO::PARAM_STR, 255);
		$cmd->bindParam(':page_description', $page_description, PDO::PARAM_STR, 65535);
		$cmd->execute();

		// Disconnect
		$conn = null;

		// Return to list of pages
		header('location:page-list.php');
		};

} catch (Exception $e) {
	// Catch error and store in variable then send to specified email
	// Redirect user to designated error page
	mail('error@mseifried.com', 'A2 Error | save-page.php', $e);
	header('location:error.php');
};

require_once 'includes/footer.php';
ob_flush();
?>

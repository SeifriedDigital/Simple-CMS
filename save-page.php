<?php
ob_start();
$title = 'Saving Page';
$body_id = "save-page";
require_once 'includes/user-auth.php';
require_once 'includes/header.php';

try {
	// Store page info into variables
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
		echo 'A title is required<br><a href="create-page.php">Back</a>';
		$ok = false;
	}

	if (empty($page_link)) {
		echo 'Page link is required<br><a href="create-page.php">Back</a>';
		$ok = false;
	}

	if (empty($page_header)) {
		echo 'Header is required<br><a href="create-page.php">Back</a>';
		$ok = false;
	}

	if (empty($page_content)) {
		echo 'Content is required<br><a href="create-page.php">Back</a>';
		$ok = false;
	}

	if (empty($page_author)) {
		echo 'Author is required<br><a href="create-page.php">Back</a>';
		$ok = false;
	}

	if (empty($page_description)) {
		echo 'Description is required<br><a href="create-page.php">Back</a>';
		$ok = false;
	}


	if ($ok) {
		// Connect to database if all the above conditions pass
		require 'includes/db.php';

		$sql = "SELECT * FROM a2_pages WHERE page_link = :page_link";

		$cmd = $conn->prepare($sql);
		$cmd->bindParam(':page_link', $page_link, PDO::PARAM_STR, 255);
		$cmd->execute();

		// Fetch all the database entries returned by the query then count them
		$a2_pages = $cmd->fetchAll();
		$count = $cmd->rowCount();

		// Validates that each page has a unique page link
		if ($count == 1 || $count > 1) {
			echo 'Page link name is already in use.<br /><a href="create-page.php">Back</a>';
			$conn = null;
			exit();
		} else {
			// This runs if there is no page with the desired link name
			// Create SQL query to add user to database

			$sql = "INSERT INTO a2_pages (page_title, page_link, page_header, page_content, page_order, page_author, page_description) VALUES (:page_title, :page_link, :page_header, :page_content, :page_order, :page_author, :page_description)";

			// Bind parameters and execute
			$cmd = $conn->prepare($sql);
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

			// Return to admin page control
			header('location:page-list.php');
		}
	}

} catch (Exception $e) {
	// Catch error and store in variable then send to specified email
	// Redirect user to designated error page
	mail('error@mseifried.com', 'A2 Error | save-page.php', $e);
	header('location:error.php');
};
require_once 'includes/footer.php';
ob_flush();
?>

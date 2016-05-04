<?php
ob_start();
// Get page data from database via page_id
$page_id = $_GET['page_id'];
$body_id = "index";

try {
	if (!empty($page_id)) {
		require 'includes/db.php';

		$sql = "SELECT * FROM a2_pages WHERE page_id = :page_id";
		$cmd = $conn->prepare($sql);
		$cmd->bindParam(':page_id', $page_id, PDO::PARAM_INT);
		$cmd->execute();
		$a2_pages = $cmd->fetchAll();

		// Store data into variables for easy manipulation
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


		// Set head information from database then require header
		$page_description = $page_description;
		$page_author = $page_author;
		$title = $page_title;
		require 'includes/header.php';


		// Setup and inject content from database
		echo '
		<h1>' . $page_header . '</h1>
		<p>' . $page_content . '</p>	
	';
	} else {
		$title = "Home";
		require 'includes/header.php';
		$page_description = "A basic CMS created by Mat Seifried as an assignment for his Web Programming/PHP school course.";
		$page_author = "Mat Seifried";

		echo'
			<h1>Welcome</h1>
			<p>This site was created as part of my Web Programming/PHP course. It is a basic content management system allowing users to create their own pages and page content.</p>
		';
	}

	// Disconnect after both above query and header querys run
	$conn = null;

} catch (Exception $e) {
	// Catch error and store in variable then send to specified email
	// Redirect user to designated error page
	mail('error@mseifried.com', 'A2 Error | index.php', $e);
	header('location:error.php');
};

require_once 'includes/footer.php';
ob_flush();
?>

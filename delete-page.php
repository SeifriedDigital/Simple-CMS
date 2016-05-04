<?php
ob_start();
require_once 'includes/user-auth.php';
require_once 'includes/header.php';

// Store page_id from url on page-list.php
$page_id = $_GET['page_id'];

try {
	// Execute if page_id is numeric, helps with security/authentication
	if (is_numeric($page_id)) {

		// Connect to database
		require_once 'includes/db.php';

		// Bind and execute query
		$sql = "DELETE FROM a2_pages WHERE page_id = :page_id";

		$cmd = $conn->prepare($sql);
		$cmd->bindParam(':page_id', $page_id, PDO::PARAM_INT);
		$cmd->execute();

		// Disconnect
		$conn = null;

		// Redirect back to page-list.php
		header('location:page-list.php');
	}
	
} catch (Exception $e) {
	// Catch error and store in variable then send to specified email
	// Redirect user to designated error page
	mail('error@mseifried.com', 'A2 Error | delete-page.php', $e);
	header('location:error.php');
};

require_once 'includes/footer.php';
ob_flush();
?>
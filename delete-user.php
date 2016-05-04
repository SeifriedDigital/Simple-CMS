<?php
ob_start();
require_once 'includes/user-auth.php';
require_once 'includes/header.php';

// Store user_id from url on user-list.php
$user_id = $_GET['user_id'];

try {
	// Execute if user_id is numeric, helps with security/authentication
	if (is_numeric($user_id)) {

		// Connect to database
		require_once 'includes/db.php';

		// Bind and execute query
		$sql = "DELETE FROM a2_users WHERE user_id = :user_id";

		$cmd = $conn->prepare($sql);
		$cmd->bindParam(':user_id', $user_id, PDO::PARAM_INT);
		$cmd->execute();

		// Disconnect
		$conn = null;

		// Redirect back to user-list.php
		header('location:user-list.php');
	}

} catch (Exception $e) {
	// Catch error and store in variable then send to specified email
	// Redirect user to designated error page
	mail('info@mseifried.com', 'A2 Error | delete-user.php', $e);
	header('location:error.php');
};

require_once 'includes/footer.php';
ob_flush();
?>

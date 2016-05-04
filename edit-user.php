<?php
ob_start();
$title = "Edit Registered User";
$body_id = "edit-user";
require_once 'includes/user-auth.php';
require_once 'includes/header.php';

$user_id = $_GET['user_id'];

try {
	// Requires the user to make edits by clicking edit on user-list.php this avoids errors and improves security/validation.
	if ((!empty($user_id)) && (is_numeric($user_id))) {

		require_once 'includes/db.php';

		// Get data for selected user
		$sql = "SELECT username, email FROM a2_users WHERE user_id = :user_id";
		$cmd = $conn->prepare($sql);
		$cmd->bindParam(':user_id', $user_id, PDO::PARAM_INT);
		$cmd->execute();
		$a2_users = $cmd->fetchAll();

		// Loop through each column for returned user_id row and bind database data to variables
		foreach ($a2_users as $user) {
			$username = $user['username'];
			$email = $user['email'];
		}

		// Disconnect
		$conn = null;

		// Echo out form with pre-existing page data that can be edited
		echo '
			<h1>Edit User Data</h1>
			<p>Enter new credentials for ' . $username . '.</p>
			<form method="post" action="save-user-edit.php">
				<input type="number" name="user_id" readonly style="display: none;" value="' . $user_id . '">
				<div>
					<label for="username">Name:</label>
					<input type="text" name="username" value="' . $username . '" required>
				</div>
				<div>
					<label for="email">Email:</label>
					<input type="email" name="email" value="' . $email . '" required>
				</div>
				<div>
					<label for="password">Password:</label>
					<input type="password" name="password" required>
				</div>
				<div>
					<label for="confirm">Confirm Password:</label>
					<input type="password" name="confirm">
				</div>
				<div>
					<button type="submit">Update User</button>
				</div>
			</form>
			';
	} else {
		echo '<p>You need to access this page by clicking "Edit" on a user found on the <a href="user-list.php">user list</a>.</p>';
	}

} catch (Exception $e) {
	// Catch error and store in variable then send to specified email
	// Redirect user to designated error page
	mail('error@mseifried.com', 'A2 Error | edit-user.php', $e);
	header('location:error.php');
};

require_once 'includes/footer.php';
ob_flush();
?>
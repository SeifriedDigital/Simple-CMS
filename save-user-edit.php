<?php
ob_start();
$title = 'Updating User';
$body_id = "save-user-edit";
require_once 'includes/user-auth.php';
require_once 'includes/header.php';

try {
	// Store updated credentials as variables
	$user_id = $_POST['user_id'];
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$confirm = $_POST['confirm'];
	$ok = true;

	// validation
	if (empty($username)) {
		echo 'Username is required<br />';
		$ok = false;
	}

	if (empty($email)) {
		echo 'Email is required<br />';
		$ok = false;
	}

	if (empty($password)) {
		echo 'Password is required<br />';
		$ok = false;
	}

	if ($password != $confirm) {
		echo 'Passwords must match<br />';
		$ok = false;
	}

	if ($ok) {
		$hashed_password = hash('sha512', $password);

		// Connect to database if all the above conditions pass
		require 'includes/db.php';

		$sql = "UPDATE a2_users SET username = :username, email = :email, password = :password WHERE user_id = :user_id;";

		$cmd = $conn->prepare($sql);
		$cmd->bindParam(':user_id', $user_id, PDO::PARAM_INT);
		$cmd->bindParam(':username', $username, PDO::PARAM_STR, 255);
		$cmd->bindParam(':email', $email, PDO::PARAM_STR, 255);
		$cmd->bindParam(':password', $hashed_password, PDO::PARAM_STR, 128);
		$cmd->execute();

		echo 'User credentials updated click <a href="user-list.php">here</a> to return to the users list';
	} else {
		echo '<p><a href="user-list.php">Back</a></p>';
	}

} catch (Exception $e) {
	// Catch error and store in variable then send to specified email
	// Redirect user to designated error page
	mail('error@mseifried.com', 'A2 Error | save-user-edit.php', $e);
	header('location:error.php');
};

require_once 'includes/footer.php';
ob_flush();
?>

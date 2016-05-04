<?php
ob_start();
$title = "Login Validation";

try {
	require_once 'includes/header.php';

	// Store form data from login.php
	$email = $_POST['email'];
	$password = hash('sha512', $_POST['password']);

	// Connect to database
	require 'includes/db.php';

	// Query to search for user in database
	$sql = "SELECT * FROM a2_users WHERE email = :email AND password = :password";

	// Prepare and execute SQL query by binding login data
	$cmd = $conn->prepare($sql);
	$cmd->bindParam(':email', $email, PDO::PARAM_STR, 254);
	$cmd->bindParam(':password', $password, PDO::PARAM_STR, 128);
	$cmd->execute();

	// Fetch all the database entries returned by the query then count them
	$a2_users = $cmd->fetchAll();
	$count = $cmd->rowCount();

	// If count == 0 that means there is no user with that email and password combination and login does not complete
	if ($count == 0) {
		echo '<p>User not found<br>
		<a href="login.php">Back</a></p>';
		exit();
	} else {
		// If a row is returned log user into existing session
		session_start();
		foreach  ($a2_users as $user) {
			$_SESSION['user_id'] = $user['user_id'];
		}
	}

	// Disconnect
	$conn = null;

} catch (Exception $e) {
	// Catch error and store in variable then send to specified email
	// Redirect user to designated error page
	mail('error@mseifried.com', 'A2 Error | login-validation.php', $e);
	header('location:error.php');
};

//Redirect to admin-area
header('location: admin-console.php');

include_once 'includes/footer.php';
ob_flush();
?>
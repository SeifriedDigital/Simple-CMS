<?php
$title = 'Registering User';
require_once 'includes/header.php';

// Access the current session if there is one, used for displaying alternate data on page
//session_start();

// Store user info in variables
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm = $_POST['confirm'];

// Validation boolean
$ok = true;

// Validate the input data
if (empty($username)) {
	echo 'Username is required<br />';
	$ok = false;
}

if (empty($email)) {
	echo 'Email is required<br><a href="create-user.php">Back</a>';
	$ok = false;
}

if (empty($password)) {
	echo 'Password is required<br><a href="create-user.php">Back</a>';
	$ok = false;
}

if ($password != $confirm) {
	echo 'Passwords must match<br><a href="create-user.php">Back</a>';
	$ok = false;
}

if ($ok) {
	// Connect to database if all the above conditions pass
	require 'includes/db.php';

	$sql = "SELECT * FROM a2_users WHERE email = :email OR username = :username";

	$cmd = $conn->prepare($sql);
	$cmd->bindParam(':username', $username, PDO::PARAM_STR, 255);
	$cmd->bindParam(':email', $email, PDO::PARAM_STR, 255);
	$cmd->execute();

	// Fetch all the database entries returned by the query then count them
	$a2_users = $cmd->fetchAll();
	$count = $cmd->rowCount();

	// Validates that there is only one registration per email in the database
	if ($count > 0) {
		echo '<p>Username and/or email is already registered</p><br /><a href="create-user.php">Back</a>';
		$conn = null;
		exit();
	} else {
	//	This is run only if there is no currently registered user with the desired username and/or email

		// Hash user password
		$hashed_password = hash('sha512', $password);

		// Query to save new user info
		$sql = "INSERT INTO a2_users (username, email, password) VALUES (:username, :email, :password)";

		// Bind parameters and execute
		$cmd = $conn->prepare($sql);
		$cmd->bindParam(':username', $username, PDO::PARAM_STR, 255);
		$cmd->bindParam(':email', $email, PDO::PARAM_STR, 255);
		$cmd->bindParam(':password', $hashed_password, PDO::PARAM_STR, 128);
		$cmd->execute();

		// Disconnect
		$conn = null;

		// Echo alternate redirect links depending on logged in status
		if (!empty($_SESSION['user_id'])) {
			echo '<p>New user was created, click here to return to the <a href="user-list.php">user list</a>.</p>';
		} else {
			echo '<p>Registration complete, sign in <a href="login.php">here</a>.</p>';
		}
	}
}
require_once 'includes/footer.php';
?>

<?php
ob_start();
$title = "Admin Console";
$body_id = "admin-console";
require_once 'includes/user-auth.php';
require_once 'includes/header.php';

try {
	require_once 'includes/db.php';

	// Sore user_id for <h1> greeting
	$user_id = $_SESSION['user_id'];

	$sql = "SELECT username FROM a2_users where user_id = :user_id";

	// Execute and store the returned user
	$cmd = $conn->prepare($sql);
	$cmd->bindParam(':user_id', $user_id, PDO::PARAM_STR, 255);
	$cmd->execute();
	$username = $cmd->fetchColumn();

} catch (Exception $e) {
	// Catch error and store in variable then send to specified email
	// Redirect user to designated error page
	mail('info@mseifried.com', 'A2 Error | admin-console.php', $e);
	header('location:error.php');
};

// Greet admin user with their username
echo '<h1>Hello ' . $username . '</h1>';
?>

<nav>
	<ul>
		<li><a href="user-list.php">Users</a></li>
		<li><a href="page-list.php">Pages</a></li>
		<li><a href="logo.php">Logo</a></li>
	</ul>
</nav>

<?php
require_once 'includes/footer.php';
ob_flush();
?>

<?php
ob_start();
$title = "Create A Page";
$main_id = "create-page";
require_once 'includes/user-auth.php';
require_once 'includes/header.php';

try {
	require_once 'includes/db.php';

	// Store user_id for use within Author input, provides a simple auto fill feature
	$user_id = $_SESSION['user_id'];

	$sql = "SELECT username FROM a2_users where user_id = :user_id";

	// Execute and store the returned username
	$cmd = $conn->prepare($sql);
	$cmd->bindParam(':user_id', $user_id, PDO::PARAM_STR, 255);
	$cmd->execute();
	$username = $cmd->fetchColumn();

} catch (Exception $e) {
	// Catch error and store in variable then send to specified email
	// Redirect user to designated error page
	mail('error@mseifried.com', 'A2 Error | create-page.php', $e);
	header('location:error.php');
};

ob_flush();
?>

<h1>Create A New Page</h1>
<form method="post" action="save-page.php">
	<div>
		<label for="page_title">Page Title:</label>
		<input type="text" name="page_title" required>
	</div>
	<div>
		<label for="page_link">Page Link:</label>
		<input type="text" name="page_link" required>
	</div>
	<div>
		<label for="page_header">Page Header:</label>
		<input type="text" name="page_header" required>
	</div>
	<div>
		<label for="page_content">Page Content:</label>
		<textarea name="page_content" required></textarea>
	</div>
	<div>
		<label for="page_order">Display Order:</label>
		<input type="number" name="page_order">
	</div>
	<div>
		<label for="page_author">Author:</label>
		<input type="text" name="page_author" value="<?php echo $username; ?>" required>
	</div>
	<div>
		<label for="page_description">Description:</label>
		<textarea name="page_description" required></textarea>
	</div>
	<div>
		<button type="submit">Create Page</button>
	</div>
</form>

<?php
require_once 'includes/footer.php';
?>
<?php
$body_id ="create-user";
// Access the current session if there is one
session_start();

// If logged in admin user accesses this page a different message will be echo'd alongside a different page title
if (!empty($_SESSION['user_id'])) {
	$title = "Add New Admin User";

	// Require header here so that HTML tag title is properly updated through above if statement
	require_once 'includes/header.php';

	echo '<h1>Add A New Administrator</h1>';
} else {
	$title = "Register";

	// Require header here so that HTML tag title is properly updated through above if statement
	require_once 'includes/header.php';

	echo '<h1>Registration</h1>';
}
?>

<form method="post" action="save-user.php">
	<div>
		<label for="username">Username:</label>
		<input type="text" name="username" required>
	</div>
	<div>
		<label for="email">Email:</label>
		<input type="email" name="email" required>
	</div>
	<div>
		<label for="password">Password:</label>
		<input type="password" name="password" required>
	</div>
	<div>
		<label for="confirm">Confirm Password:</label>
		<input type="password" name="confirm">
	</div>
	<div class="g-recaptcha" data-sitekey="6LfdGh8TAAAAAM5MleEDdAM6rFAo0KDEqqNRpXQ8">

	</div>
	<div>
		<button type="submit">Register</button>
	</div>
</form>

<?php
require_once 'includes/footer.php';
?>
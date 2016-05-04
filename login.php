<?php
$title = "Login";
$body_id = "login";
require_once 'includes/header.php';
?>

<h1>Login</h1>
<form method="post" action="login-validation.php">
	<div>
		<label for="email">Email:</label>
		<input type="email" name="email" required>
	</div>
	<div>
		<label for="password">Password:</label>
		<input type="password" name="password" required>
	</div>
	<div>
		<button type="submit">Login</button>
	</div>
</form>

<?php
require_once 'includes/footer.php';
?>

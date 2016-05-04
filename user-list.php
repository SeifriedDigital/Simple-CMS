<?php
$title = "Registered Users";
$body_id = "user-list";
require_once 'includes/user-auth.php';
require_once 'includes/header.php';

try {
	// Connect to database
	require 'includes/db.php';

	// Query to search for registered users in database
	$sql = "SELECT user_id, username, email FROM a2_users";

	// Execute and store all returned a2_users as user
	$cmd = $conn->prepare($sql);
	$cmd->execute();
	$a2_users = $cmd->fetchAll();

	$conn = null;

} catch (Exception $e) {
	// Catch error and store in variable then send to specified email
	// Redirect user to designated error page
	mail('error@mseifried.com', 'A2 Error | user-list.php', $e);
	header('location:error.php');
};
?>
<h1>Registered Users</h1>
<p>Add a new admin user <a href="create-user.php">here</a>.</p>
<table>
	<thead>
		<th>User ID</th>
		<th>Username</th>
		<th>User Email</th>
		<th>Edit</th>
		<th>Delete</th>
	</thead>
	<tbody>
<?php
// Echo data into table for viewing
foreach ($a2_users as $user) {
	echo
	'<tr>
		<td>' . $user['user_id'] . '</td>
		<td>' . $user['username'] . '</td>
		<td>' . $user['email'] . '</td>
		<td><a href="edit-user.php?user_id=' . $user['user_id'] . '">Edit</a></td>
		<!-- Delete button triggers confirmation dialog before initiating delete -->
		<td><a href="delete-user.php?user_id=' . $user['user_id'] . '" id="delete-button" onclick="return confirm(\'Are you sure?\');">Delete</a></td>
	</tr>';
};
?>
	</tbody>
</table>
<?php

require_once 'includes/footer.php';
?>

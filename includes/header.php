<!DOCTYPE html>
<html lang="en">
	<head>
		<!--META-->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="<?php echo $page_description; ?>">
		<meta name="author" content="<?php echo $page_author; ?>">
		<title><?php echo $title; ?></title>
		<!--CSS-->
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="css/main.css">
		<!--reCAPATCHA-->
		<script src='https://www.google.com/recaptcha/api.js'></script>
	</head>
	<?php echo '<body id="' . $body_id . '">'; ?>
		<header>
			<img src="uploads/header-logo" alt="Logo/Brand">
			<nav>
				<ul>
					<?php
					// Echo private nav for logged in users else echo public nav
					if (!empty($_SESSION['user_id'])) {
						echo '
							<li id="index-link"><a href="index.php" target="_blank">Public Site</a></li>
							<li id="admin-console-link"><a href="admin-console.php">Admin Console</a></li>
							<li><a href="logout.php">Logout</a></li>
						';
					} else {
						try {
							require 'includes/db.php';
							$sql = "SELECT page_id, page_link FROM a2_pages ORDER BY page_order";

							// Execute and store all returned a2_users as user
							$cmd = $conn->prepare($sql);
							$cmd->execute();
							$a2_pages = $cmd->fetchAll();

							$conn = null;

							echo '<li id="index-link"><a href="index.php">Home</a></li>';

								// Echo out each page in header navigation
								foreach ($a2_pages as $page) {
										echo '<li id="' . $page['page_id'] . '"><a href="index.php?page_id=' . $page['page_id'] . '">' . $page['page_link'] . '</a></li>';
								}
						} catch (Exception $e) {
							// Catch error and store in variable then send to specified email
							// Redirect user to designated error page
							mail('info@mseifried.com', 'A2 Error | header.php', $e);
							header('location:error.php');
						};

						echo '<li><a href="create-user.php">Register</a></li>
							  <li><a href="login.php">Login</a></li>';
					}
					?>
				</ul>
			</nav>
		</header>
		<main>
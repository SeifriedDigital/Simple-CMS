<?php
ob_start();

// Access the current session
session_start();

// If there is no session to access than redirect to login page
if (empty($_SESSION['user_id'])) {
	header('location:login.php');
	exit();
}

ob_flush();
?>
<?php
ob_start();

// End session removing authentication for admin pages
session_start();
session_unset();
session_destroy();

// Redirect user to home page after clicking logout
header('location:index.php');

ob_flush();
?>
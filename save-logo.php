<?php
$title = "Saving Logo";
$body_id = "save-logo";
require_once 'includes/user-auth.php';
require_once 'includes/header.php';

// Store file information in variables
$logo_name = $_FILES['any_file']['name'];
echo "Name: $logo_name<br>";

$logo_size = $_FILES['any_file']['size'];
echo "Size: $logo_size<br>";

$logo_type = $_FILES['any_file']['type'];
echo "Type: $logo_type<br>";

$tmp_name = $_FILES['any_file']['tmp_name'];
echo "Tmp Name: $tmp_name<br>";

// Store image final name so that the last uploaded logo overwrites the previous.
session_start();
$final_name = "header-logo";

// Image validation
$ok = true;

// Allowed file type if statement based off
// http://stackoverflow.com/questions/10456113/php-check-file-extension-in-upload-form
// user: Baba
$allowed =  array('image/gif', 'image/png', 'image/jpg', 'image/jpeg');
if(!in_array($logo_type,$allowed)) {
	$ok = false;
	echo 'File type is not supported.';
}

if ($logo_size > 3145728) {
	$ok = false;
	echo 'Selected file is too large, use an image under 3MB.';
}

if ($ok == true) {
	// Move file from server cache to destination
	move_uploaded_file($tmp_name, "uploads/$final_name");
	echo '<img src="uploads/header-logo">';
}

require_once 'includes/footer.php';
?>
<?php
$title = 'Logo Upload';
$body_id = "logo";
require_once 'includes/user-auth.php';
require_once 'includes/header.php';
?>

<p>Download a header logo template <a href="public-files/header-template.ai" alt="AI File">here</a>.</p>
<form method="post" action="save-logo.php" enctype="multipart/form-data">
	<label for="any_file">3MB Max (jpeg, png, gif)</label>
	<input type="file" name="any_file" >
	<button>Upload</button>
</form>

<?php
require_once 'includes/footer.php';

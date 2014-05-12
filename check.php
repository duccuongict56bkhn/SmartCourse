<?php 
# Check user availability
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	include_once 'core/init.php';

	if (!empty($_POST['username'])) {
		$username = $_POST['username'];
		if (strlen($username) >= 3) {
			if ($users->user_exists($username) == 1) {
				echo 1;
			} else {
				echo 2;
			}
		}
	}

	return; 
}
?>
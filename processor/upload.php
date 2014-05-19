<?php 
require '../core/init.php';

if (isset($_POST['type'])) {
	$type = $_POST['type'];

	switch($type) {
		case 'uploadimage':
			
		break;

		default:
		break;
	}
} else {
	var_dump($_POST['type']);
}
 ?>
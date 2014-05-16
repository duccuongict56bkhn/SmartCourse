<?php 
require '../core/init.php';

if ($general->logged_in()) {
	$type = $_POST['type'];
	$course_alias = $_POST['course_alias'];
	$id = $_POST['id'];

	if (!empty($type)) {
		switch ($type) {
			case 'announcement':
				$flag = $courses->delete_announcement($course_alias, $id);
				break;
			
			default:
				# code...
				break;
		}

		if ($flag === true) {
			return http_response_code(200);
		} else {
			return http_response_code(400);
		}
	}

} else {
	die();
}

 ?>
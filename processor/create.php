<?php 
require '../core/init.php';

if ($general->logged_in()) {
	$type = $_POST['type'];
	$course_alias = $_POST['course_alias'];
	$course_id = $courses->get_ifa($course_alias);

	if (!empty($type)) {
		switch ($type) {
			case 'announcement':
				$anno_id = 1 + $courses->get_max_announcement_id($course_id);
				$anno_title = $_POST['anno_title'];
				$anno_content = $_POST['anno_content'];
				$valid_from = date('Y-m-d', strtotime($_POST['valid_from']));
				$valid_to = date('Y-m-d', strtotime($_POST['valid_to']));
				$anno_type = $_POST['anno_type'];
				$create_date = time();

				$flag = $courses->create_announcement($user_id, $course_id, $anno_id, $anno_title,
	                                    $anno_content, $create_date, $anno_type, $valid_from, $valid_to);
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
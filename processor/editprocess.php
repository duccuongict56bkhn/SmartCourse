<?php 
require '../core/init.php';

	$pk = $_POST['pk'];
	$name = $_POST['name'];
	$value = $_POST['value'];

	if (!empty($value)) {
		switch ($name) {
			case 'course_title':
				$flag = $courses->update($pk, 'course_title', $value);	
				break;
			case 'school':
				$flag = $courses->update($pk, 'school', $value);	
				break;
			case 'course_desc':
				$flag = $courses->update($pk, 'course_desc', $value);	
				break;
			case 'length' :
				$flag = $courses->update($pk, 'length', $value);
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
	} else {
		return http_response_code(400);
	}
 ?>
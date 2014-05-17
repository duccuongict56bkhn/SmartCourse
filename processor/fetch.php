<?php 
require '../core/init.php';

if (isset($_POST['type'])) {
	$type = $_POST['type'];

	switch ($type) {
		case 'exercise':
			if (!empty($_POST['unit_id']) && !empty($_POST['course_alias'])) {
				$unit_id = $_POST['unit_id'];
				$course_alias = $_POST['course_alias'];
				$course_id = $courses->get_ifa($course_alias);
            
				$exercises = $courses->get_all_unit_exercise($course_id, $unit_id);

				return $exercises;
			} else {
				die();
			}
			break;

		case 'unitexercise':
			if (!empty($_POST['unit_id']) && !empty($_POST['course_alias'])) {
				$unit_id = $_POST['unit_id'];
				$course_alias = $_POST['course_alias'];
				$course_id = $courses->get_ifa($course_alias);
            
				$exercises = $courses->get_exercise_by_unit($course_id, $unit_id);

				echo json_encode($exercises);
			}
			break;

		default:
			# code...
			break;
		}
} else {
	die();
}
 ?>
<?php 
require '../core/init.php';

if ($general->logged_in()) {

	$type = $_POST['type'];
	if (!empty($type)) {
		switch ($type) {
			case 'announcement':
				$course_alias = $_POST['course_alias'];
				$course_id = $courses->get_ifa($course_alias);
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
			
			case 'exercise_attempt':
				$course_id = $_POST['course_id'];
				$unit_id   = $_POST['unit_id'];
				$exercise_id = $_POST['exercise_id'];
				$question_type = $_POST['question_type'];
				$answer = $_POST['answer'];
				$status = $_POST['status'];

				/* In case of multiple choice question, check answer immediately */
				if ($question_type == 1) {
					$correct = $courses->multi_choice_get_correct_answer($course_id, $unit_id, $exercise_id);
					if ($correct) {
						$flag = $courses->multi_choice_exercise_submit($user_id, $course_id, $unit_id, $exercise_id, $answer,
		                                          '', 3);
						echo $flag;
					} else {
						$flag = $courses->multi_choice_exercise_submit($user_id, $course_id, $unit_id, $exercise_id, $answer,
		                                          '', 4);
						echo $flag;
					}
				} else if ($question_type == 2) {
					$flag = $courses->multi_choice_exercise_submit($user_id, $course_id, $unit_id, $exercise_id, '',
		                                          $answer, 2);
					echo $flag;
				}
				
			break;

			case 'exercise_save':
				$course_id = $_POST['course_id'];
				$unit_id   = $_POST['unit_id'];
				$exercise_id = $_POST['exercise_id'];
				$question_type = $_POST['question_type'];
				$answer = $_POST['answer'];
				$status = $_POST['status'];

				/* In case of multiple choice question, check answer immediately */
				if ($question_type == 1) {
					
						$flag = $courses->multi_choice_exercise_submit($user_id, $course_id, $unit_id, $exercise_id, $answer,
		                                          '', 1);
						echo $flag;

				} else if ($question_type == 2) {
					$flag = $courses->multi_choice_exercise_submit($user_id, $course_id, $unit_id, $exercise_id, '',
		                                          $answer, 1);
					echo $flag;
				}
				
			break;
			default:
				# code...
				break;
		}

		// 
	}

} else {
	die();
}

 ?>
<?php 
// Process form for create new exercises
require 'core/init.php';

$data 		= array();		// Data to be push back

if (empty($_POST['course'])) {
	$errors['course'] = 'You need to specify the course';
}

# Validate form input
if (empty($_POST['exercise_title'])) {
	$errors['exercise_title'] = 'Title is required';
}
if (empty($_POST['unit_id'])) {
	$errors['unit_id'] = 'You need to specify lecture';
}
if (empty($_POST['question_type'])) {
	$errors['question_type'] = 'You need to specify question type';
}
if (empty($_POST['score'])) {
	$errors['score'] = 'You need to specify score';
}
if (empty($_POST['attempt_limit'])) {
	$errors['attempt_limit'] = 'You need to specify maximum number of attempt';
}
if (empty($_POST['question'])) {
	$errors['question'] = 'You need to specify question';
}

# If there is any error
if (!empty($errors)) {
	$data['success'] = false;
	$data['errors'] = $errors;
} else {
	#if there is no error, then insert the new exercise to database
	$alias 		  		= $_POST['course'];
	// $course_id    		= $courses->get_info('course_id', 'course_alias', $_POST['course']);
	$course_id        = $courses->get_ifa($_POST['course']);

	$unit_id		  		= $_POST['unit_id'];
	$exercise_id  		= 1 + $courses->get_max_exercise_id($course_id, $unit_id);
	$exercise_title	= $_POST['exercise_title'];
	$question_type		= $_POST['question_type'];
	$score 			   = $_POST['score'];
	$attempt_limit  	= $_POST['attempt_limit'];
	$question 			= $_POST['question'];
	$multi_one 			= $_POST['multiple_one'];
	$multi_two 			= $_POST['multiple_two'];
	$multi_three		= $_POST['multiple_three'];
	$multi_four    	= $_POST['multiple_four'];
	$correct_answer   = $_POST['correct_answer'];

	if ($question_type == 1) {
		$courses->create_exercise($unit_id, $course_id, $exercise_id,$exercise_title, 
											  $question_type, $score, $attempt_limit, $question, 
											  $multi_one, $multi_two, $multi_three, $multi_four, $correct_answer);
	} else {
		$courses->create_exercise($unit_id, $course_id, $exercise_id,$exercise_title, 
											  $question_type, $score, $attempt_limit, $question, 
											 '', '', '', '', '');
	}
	
	$data['success'] = true;
	$data['message'] = 'Success!';
 }
 echo json_encode($data);
 ?>

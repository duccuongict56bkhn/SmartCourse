<?php 
// Process form for create new exercises
require 'core/init.php';

$data 		= array();		// Data to be push back

if (empty($_POST['course'])) {
	$errors[] = 'You need to specify the course';
}

# Validate form input
if (empty($_POST['exercise_title'])) {
	$errors[] = 'Title is required';
}
if (empty($_POST['unit_id'])) {
	$errors[] = 'You need to specify lecture';
}
if (empty($_POST['question_type'])) {
	$errors[] = 'You need to specify question type';
}
if (empty($_POST['score'])) {
	$errors[] = 'You need to specify score';
}
if (empty($_POST['attempt_limit'])) {
	$errors[] = 'You need to specify maximum number of attempt';
}
if (empty($_POST['question'])) {
	$errors[] = 'You need to specify question';
}

# If there is any error
if (!empty($errors)) {
	$data['success'] = false;
	$data['errors'] = $errors;
} else {
	#if there is no error, then insert the new exercise to database

	$data['success'] = true;
	$data['message'] = 'Success!';
 }
 echo json_encode($data);
 ?>

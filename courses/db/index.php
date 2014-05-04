<?php 
require '../../core/init.php';	# For further include
$general->logged_out_protect();

# Fetch basic course information
if (isset($_GET['course']) && !empty($_GET['course'])) {
	# Set <title> of the page as course's name
	$id = $courses->get_info('course_id', 'course_alias', $_GET['course']);
	$course_data = $courses->coursedata($id);
	$units = $courses->get_units($id);
	require '../course.tmpl.php';
	
} else {
	header('Location: /');
	exit();
}

?>
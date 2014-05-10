<?php
$tmp = $_SERVER['REQUEST_URI']; 
if ($tmp == '/studyhub/courses/') {
	header('Location: /studyhub/');
	exit();
} else {
	require '../../core/init.php';	# For further include
	if ($general->logged_in() === true) { # Dont' know why yet, but this is to prevent infite redirect
		$general->logged_out_protect();
	}
	#$user_id = $_SESSION['user_id'];
	# Set <title> of the page as course's name
	// $id = $courses->get_info('course_id', 'course_alias', $alias);
	$id    = $courses->get_ifa($alias);
	$course_data = $courses->coursedata($id);
	$units = $courses->get_units($id);
	$annos = $courses->get_announcement($id);
	require '../course.tmpl.php';
}
?>
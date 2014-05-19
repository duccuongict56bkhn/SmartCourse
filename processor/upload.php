<?php 
require '../core/init.php';

if (isset($_POST['type'])) {
	$type = $_POST['type'];

	switch($type) {
		case 'uploadimage':
			$course_id = $_POST['course_id'];
			$avatar = $_POST['avatar'];
			$course_cover = $_POST['course_cover'];

			$avatar = str_replace('data:image/png;base64,', '', $avatar);
			$dava = base64_decode($avatar);

			$course_cover = str_replace('data:image/png;base64,', '', $course_cover);
			$dcover= base64_decode($course_cover);

			$course_alias = $courses->get_info('course_alias', 'course_id', $course_id);
			
			$db_avatar = 'images/courses/'.$course_alias . '.png';
			$avatar_path = '../images/courses/';
			file_put_contents('../images/courses/cavatar.png', $dava);
			rename('../images/courses/cavatar.png', '../images/courses/'.$course_alias.'.png');

			$db_cover = 'images/courses/'.$course_alias . '.cover.png';
			$cover_path = '..'.$db_cover;
			file_put_contents('../images/courses/cavatar.png', $dcover);
			rename('../images/courses/cavatar.png', '../images/courses/'.$course_alias.'.cover.png');

			$flag = $courses->update_photo($course_id, $db_avatar, $db_cover);

			if ($flag === true) {
				echo 1;
			} else {
				echo 0;
			}
		break;

		default:
		break;
	}
} else {
	var_dump($_POST['type']);
}
 ?>
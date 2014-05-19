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

		case 'studentsubmit':
			$user_id = $_POST['user_id'];
			$course_id = $_POST['course_id'];
			$unit_id = $_POST['unit_id'];

			
		break;

		case 'checkuserexistence':
			$username = $_POST['username'];

			$flag = $users->user_exists($username);

			if ($flag === true) {
				echo 1;
			} else {
				echo 0;
			}
		break;

		case 'updateuserprofile':
			$username = $_POST['username'];
			$first_name = $_POST['first_name'];
			$last_name = $_POST['last_name'];
			$bio = $_POST['bio'];
			$gender = $_POST['gender'];
			$display_name = $_POST['display_name'];
			$avatar = $_POST['avatar'];
			$avatar = str_replace('data:image/png;base64,', '', $avatar);
			$data = base64_decode($avatar);		

			$avatar_path = '../images/avatars/'. $username . '.png';
			$db_avatar = 'images/avatars/'. $username . '.png';
			file_put_contents('../images/avatars/avatar.png', $data);
			rename('../images/avatars/avatar.png', '../images/avatars/' . $username . '.png');
			
			$user_id = $users->fetch_info('user_id', 'username', $username);
			$flag = $users->update_user($user_id, $first_name, $last_name, $bio, $gender, $display_name, $db_avatar);
			if ($flag === true) {
				echo 1;
			} else {
				echo 0;
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
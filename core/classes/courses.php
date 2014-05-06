<?php 
class Courses {
	private $db;

	public function __construct($database) {
		$this->db = $database;
	}

	/**
	 * Check for existing course
	 **/
	public function course_exists($value)
	{
		$query = $this->db->prepare("SELECT COUNT(1) FROM `sm_courses` WHERE (`course_alias` = ?) OR (`course_code` = ?)");
		$query->bindValue(1, $value);
		$query->bindValue(2, $value);

		try {
			$query->execute();
			$rows = $query->fetchColumn();

			if ($rows == 1) {
				return true;
			} else {
				return false;
			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function alias_exists($alias)
	{
		$query = $this->db->prepare("SELECT COUNT(`course_id`) FROM `sm_courses` WHERE `course_alias` = '?'");
		$query->bindValue(1, $alias);

		try {
			$query->execute();

			$rows = $query->fetchAll();
			if ($rows == 1) {
				return true;
			}

			return false;
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function create_course($course_title, $course_code, $course_alias, $cat_id, $course_type, $start_date, $length, $user_id)
	{
		$create_date = time();

		$query = $this->db->prepare("INSERT INTO `sm_courses` (`course_title`, `course_code`, `course_alias`, `cat_id`,`course_type`, `start_date`, `length`)
									 VALUES (?, ?, ?, ?, ?, ?, ?)");
		$query->bindValue(1, $course_title);
		$query->bindValue(2, $course_code);
		$query->bindValue(3, $course_alias);
		$query->bindValue(4, $cat_id);
		$query->bindValue(5, $course_type);
		$query->bindValue(6, $start_date);
		$query->bindValue(7, $length);

		try {
			$query->execute();

			$id = $this->get_info('course_id', 'course_alias', $course_alias);

			$query_f = $this->db->prepare("INSERT INTO `sm_create_course`(`user_id`, `course_id`, `create_date`)
										   VALUES (?, ?, ?)");
			$query_f->bindValue(1, $user_id);
			$query_f->bindValue(2, $id);
			$query_f->bindValue(3, $create_date);

			$query_f->execute();

			$this->build_structure($course_alias);
			return true;		# Successfully create the course
		} catch (PDOException $e) {
			die($e->getMessage());
		}
		return false;
	}

	private function build_structure($course_alias)
	{
		$folder = 'courses/'.$course_alias;
		$dir	  = mkdir($folder, 755);
		$img	  = $folder . '/img';
		$vid    = $folder . '/videos';
		$slide  = $folder . '/slides';

		mkdir($img, 755);
		mkdir($vid, 755);
		mkdir($slide, 755);
		
		# create index file
		file_put_contents($folder . '/index.php', '<?php $alias = \'' . $course_alias . '\'; require \'../index.php\';?>');
		# create lecture file
		file_put_contents($folder . '/lecture.php', '<?php $alias = \'' . $course_alias . '\'; require \'../index.php\';?>');
		# create exercise file
		file_put_contents($folder . '/exercise.php', '<?php $alias = \'' . $course_alias . '\'; require \'../index.php\';?>');
		# create syllabbus file
		file_put_contents($folder . '/syllabus.php', '<?php $alias = \'' . $course_alias . '\'; require \'../index.php\';?>');
		# create forum file
		file_put_contents($folder . '/forum.php', '<?php $alias = \'' . $course_alias . '\'; require \'../index.php\';?>');
		# create studentlist file
		file_put_contents($folder . '/studentlist.php', '<?php $alias = \'' . $course_alias . '\'; require \'../index.php\';?>');
		# create studentsubmit file
		file_put_contents($folder . '/studentsubmit.php', '<?php $alias = \'' . $course_alias . '\'; require \'../index.php\';?>');
		# create about file
		file_put_contents($folder . '/about.php', '<?php $alias = \'' . $course_alias . '\'; require \'../index.php\';?>');
	}

	public function coursedata($course_id)
	{
		$query = $this->db->prepare("SELECT * FROM `sm_courses` WHERE `course_id` = ?");
		$query->bindValue(1, $course_id);

		try {
			$query->execute();
			return $query->fetch();
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function get_create_date($course_id)
	{
		$query = $this->db->prepare("SELECT `create_date` FROM `sm_create_course` WHERE `course_id` = ?");
		$query->bindValue(1, $course_id);

		try {
			$query->execute();
			return $query->fetchColumn();
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function update_course($course_id,$course_desc, $avatar)
	{
		$query = $this->db->prepare("UPDATE `sm_courses` SET `course_desc` = ?,
															 `avatar` = ?
														WHERE `course_id` = ?");
		$query->bindValue(1, $course_desc);
		$query->bindValue(2, $avatar);
		try {
			$query->execute();
			return true;
		} catch (PDOException $e) {
			return false;
		}
	}

	public function get_all_course_by_cat()
	{
		$results = array();
		$query = $this->db->prepare("SELECT scat.cat_title AS 'title', COUNT(smc.course_id) AS 'count'
									FROM `sm_courses` AS smc, `sm_course_cat` AS scat
									WHERE smc.cat_id = scat.cat_id
									GROUP BY scat.cat_id, scat.cat_title");
		try {
			$query->execute();

			$results = $query->fetchAll();
		} catch (PDOException $e) {
			die($e->getMessage());
		}

		if (!empty($results)) {
			return $results;
		} 

		return false;
	}

	public function get_all_courses()
	{
		$results = array();
		$query = $this->db->prepare("SELECT * FROM `sm_courses`");

		try {
			$query->execute();

			$results = $query->fetchAll();
		} catch (PDOException $e) {
			die($e->getMessage());
		}

		if (!empty($results)) {
			return $results;
		} 
		return false;
	}

	public function get_cat()
	{
		$results = array();
		$query = $this->db->prepare("SELECT * FROM `sm_course_cat` WHERE `cat_title` <> ''");

		try {
			$query->execute();

			$results = $query->fetchAll();
		} catch (PDOException $e) {
			die($e->getMessage());
		}

		if (!empty($results)) {
			return $results;
		} 
		return false;
	}

	public function get_info($what, $field, $value) 	
	{
		$allowed = array('cat_id', 'course_id', 'course_title', 'course_code', 'course_alias', 'course_desc', 'course_type',
			'create_date', 'start_date', 'length', 'course_avatar');
		if (!in_array($what, $allowed, true) || !in_array($field, $allowed, true)) {
			throw new InvalidArgumentException;
		} else {

			$query = $this->db->prepare("SELECT $what FROM `sm_courses` WHERE $field = ?");
			$query->bindValue(1, $value);

			try {
				$query->execute();
				return $query->fetchColumn();
			} catch (PDOException $e) {
				die($e->getMessage());
			}
		}
	}

	public function get_units($course_id)
	{
		$query = $this->db->prepare("SELECT * FROM `sm_units` WHERE `course_id` = ?");
		$query->bindValue(1, $course_id);
		try {
			$query->execute();
			return $query->fetchAll();
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function get_unit_video($unit_id)
	{
		$query = $this->db->prepare("SELECT `vid_id`,`vid_title`, `vid_link` FROM `sm_units` WHERE `unit_id` = ?");
		$query->bindValue(1, $unit_id);

		try {
			$query->execute();
			return $query->fetchAll();
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function get_distinct_unit($course_id)
	{
		$query = $this->db->prepare("SELECT DISTINCT `unit_id`, `unit_name` FROM `sm_units` WHERE `course_id` = ?");
		$query->bindValue(1, $course_id);

		try {
			$query->execute();
			return $query->fetchAll();
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	// public function get_exercise($course_id, $unit_id)
	// {
	// 	$query = $this->db->prepare("")
	// }

	public function search_courses($keyword)
	{
		$token = '%' . $keyword . '%';
		$results = array();
		$query = $this->db->prepare("SELECT * FROM `sm_courses` WHERE `course_title` LIKE '?'");
		$query->bindValue(1, $token);
		try {
			$query->execute();
			$results = $query->fetchAll();
			var_dump($query);
		} catch (PDOException $e) {
			die($e->getMessage());
		}

		if (!empty($results)) {
			return $results;
		} 

		return false;
	}

	public function is_created_by_me($user_id, $course_id)
	{
		$query = $this->db->prepare("SELECT COUNT(`user_id`) FROM `sm_create_course` WHERE `user_id` = ? AND `course_id` = ?");
		$query->bindValue(1, $user_id);
		$query->bindValue(2, $course_id);

		try {
			$query->execute();
			$rows = $query->fetchColumn();

			if ($rows == 1) {
				return true;
			} else {
				return false;
			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function get_announcement($course_id)
	{
		$query = $this->db->prepare("SELECT *
											  FROM `sm_course_announcements`
											  WHERE `course_id` = ?
											  ORDER BY `create_date` DESC
											  LIMIT 10");
		$query->bindValue(1, $course_id);

		try {
			$query->execute();
			return $query->fetchAll();
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function create_announcement($user_id, $course_id, $anno_id, $anno_title,
	                                    $anno_content, $create_date, $anno_type, $valid_from, $valid_to)
	{
		$query = $this->db->prepare("INSERT INTO `sm_course_announcements` (`user_id`, `course_id`, `anno_id`, `anno_title`,
																								  `anno_content`, `create_date`, `anno_type`, `valid_from`, `valid_to`)
											  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$query->bindValue(1, $user_id);
		$query->bindValue(2, $course_id);
		$query->bindValue(3, $anno_id);
		$query->bindValue(4, $anno_title);
		$query->bindValue(5, $anno_content);
		$query->bindValue(6, $create_date);
		$query->bindValue(7, $anno_type);
		$query->bindValue(8, $valid_from->format('Y-m-d H:i:s'));		# Convert DateTime back to string before insert to Database
		$query->bindValue(9, $valid_to->format('Y-m-d H:i:s'));		   # Convert DateTime back to string before insert to Database

		try {
			$query->execute();
		} catch (PDOException $e) {
			die($e->getMessage());
		}

		return $query === false;
	}

	public function create_exercise($unit_id, $course_id, $exercise_id,$exercise_title, 
											  $question_type, $score, $attempt_limit, $question, 
											  $multi_one, $multi_two, $multi_three, $multi_four, $correct_answer)
	{
		$query = $this->db->prepare("INSERT INTO `sm_exercises`(`unit_id`, `course_id`, 
															  `exercise_id`,`exercise_title`, 
						  									  `question_type`, `score`, `attempt_limit`,
						  									  `question`, `multi_one`, `multi_two`, `multi_three`, `multi_four`, `correct_answer`)
							  							VALUES (?, ?,
							  									  ?, ?,
							  									  ?, ?, ?,
							  									  ?, ?, ?, ?, ?, ?)");
		$query->bindValue(1, $unit_id);
		$query->bindValue(2, $course_id);
		$query->bindValue(3, $exercise_id);
		$query->bindValue(4, $exercise_title);
		$query->bindValue(5, $question_type);
		$query->bindValue(6, $score);
		$query->bindValue(7, $attempt_limit);
		$query->bindValue(8, $question);
		$query->bindValue(9, $multi_one);
		$query->bindValue(10, $multi_two);
		$query->bindValue(11, $multi_three);
		$query->bindValue(12, $multi_four);
		$query->bindValue(13, $correct_answer);

		try {
			$query->execute();
			return true;
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function insert_html($htmlString)
	{
		$query = $this->db->prepare("INSERT INTO `sm_html`(`content`)
									 VALUES ('" . $htmlString ."') ");
		$query->bindParam(':htmlString', $htmlString, PDO::PARAM_STR);

		try {
			$query->execute();
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}
	public function load_html($id)
	{
		$query = $this->db->prepare("SELECT `content` FROM `sm_html` WHERE `id` = $id");
		$query->bindParam('id', $id, PDO::PARAM_INT);

		try {
			$query->execute();
			return $query->fetchColumn();
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	# Fetch the maximum unit id of the course
	public function get_max_unit_id($course_id) 
	{
		$query = $this->db->prepare("SELECT IFNULL(MAX(`unit_id`), 0) FROM `sm_units` WHERE `course_id` = $course_id");
		$query->bindParam(':course_id', $course_id, PDO::PARAM_INT);

		try {
			$query->execute();
			return $query->fetchColumn();
		} catch (PDOException $e) {
			die($e->getMessage());
		}
		return false;
	}	

	public function get_max_exercise_id($course_id, $unit_id)
	{
		$query = $this->db->prepare("SELECT IFNULL(MAX(`exercise_id`), 0) FROM `sm_exercises` WHERE `course_id` = ? AND `unit_id` = ?");
		// $query->bindParam(':course_id', $course_id, PDO::PARAM_INT);
		// $query->bindParam(':unit_id', $unit_id, PDO::PARAM_INT);
		$query->bindValue(1, $course_id);
		$query->bindValue(2, $unit_id);

		try {
			$query->execute();
			return $query->fetchColumn();
		} catch (PDOException $e) {
			die($e->getMessage());
		}
		return false;
	}

	# Developing-time functions
	public function get_all_exercises($course_id) 
	{
		$query = $this->db->prepare("SELECT * FROM `sm_exercises` WHERE `course_id` = $course_id");
		$query->bindParam(':course_id', $course_id, PDO::PARAM_INT);

		try {
			$query->execute();
			return $query->fetchAll();
		} catch (PDOException $e) {
			die($e->getMessage());
		}
		return false;
	}
}

 ?>
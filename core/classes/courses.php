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
		$query = $this->db->prepare("SELECT * FROM `sm_courses` WHERE (`course_alias` = ?) OR (`course_code` = ?)");
		$query->bindValue(1, $value);
		$query->bindValue(2, $value);

		try {
			$query->execute();
			$rows = $query->fetchColumn();

			if ($rows > 0) {
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
		$query = $this->db->prepare("SELECT * FROM `sm_courses` WHERE `course_alias` = '?'");
		$query->bindValue(1, $alias);

		try {
			$query->execute();

			$rows = $query->fetchAll();
			if ($rows != 0) {
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

		$query = $this->db->prepare("INSERT INTO `sm_courses` (`course_title`, `course_code`, `course_alias`, `cat_id`,`course_type`, `create_date`, `start_date`, `length`)
									 VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
		$query->bindValue(1, $course_title);
		$query->bindValue(2, $course_code);
		$query->bindValue(3, $course_alias);
		$query->bindValue(4, $cat_id);
		$query->bindValue(5, $course_type);
		$query->bindValue(6, $create_date);
		$query->bindValue(7, $start_date);
		$query->bindValue(8, $length);

		

		try {
			$query->execute();

			// $tmp = $this->search_courses($course_alias);
			// if ($tmp <> false) {
			// 	# code...
			// }
			// $query2 = $this->db->prepare("INSERT INTO `sm_create_course`(`user_id`, `course_id`, `create_date`)
			// 						  VALUES (?, ?, ?)");
			// $query2->bindValue(1, $user_id);
			return true;		# Successfully create the course
		} catch (PDOException $e) {
			die($e->getMessage());
		}
		return false;
	}
	// public function create_course($course_title, $course_alias, $cat_id)
	// {
	// 	$query = $this->db->prepare("INSERT INTO `sm_courses` (`course_title`, `course_alias`, `cat_id`) VALUES (?, ?, ?) ");

	// 	$query->bindValue(1, $course_title);
	// 	$query->bindValue(2, $course_alias);
	// 	$query->bindValue(3, $cat_id);

	// 	try {
	// 		$query->execute();

	// 		return true;

	// 	} catch (PDOException $e) {
	// 		die($e->getMessage());
	// 	}
	// }

	public function update_course($course_id,$course_desc, $start_date, $length, $avatar)
	{
		$query = $this->db->prepare("UPDATE `sm_courses` SET `course_desc` = ?,
															 `start_date` = ?,
															 `length` = ?,
															 `avatar` = ?
														WHERE `course_id` = ?");
		$query->bindValue(1, $course_desc);
		$query->bindValue(2, $start_date);
		$query->bindValue(3, $length);
		$query->bindValue(4, $avatar);
		$query->bindValue(5, $course_id);

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

	public function search_courses($keyword)
	{
		$results = array();
		$query = $this->db->prepare("SELECT * FROM `sm_courses` WHERE (`course_title` LIKE '?') OR (`course_alias` = '?) ");
		$token = '%' . $keyword . '%';
		$query->bindValue(1, $token);
		$query->bindValue(2, $keyword);
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

}

 ?>
<?php 
class Courses {
	private $db;

	public function __construct($database) {
		$this->db = $database;
	}

	/**
	 * Check for existing course
	 **/
	public function course_exists($course_alias)
	{
		$query = $this->db->prepare("SELECT * FROM `sm_courses` WHERE `course_alias` = ?");
		$query->bindValue(1, $course_alias);

		try {
			$query->execute();
			$rows = $query->fetchColum();

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

	public function create_course($course_title, $course_alias, $cat_id)
	{
		$query = $this->db->prepare("INSERT INTO `sm_courses` (`course_title`, `course_alias`, `cat_id`) VALUES (?, ?, ?) ");

		$query->bindValue(1, $course_title);
		$query->bindValue(2, $course_alias);
		$query->bindValue(3, $cat_id);

		try {
			$query->execute();

			return true;

		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

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
		$query = $this->db->prepare("SELECT * FROM `sm_courses` WHERE `course_title` = ? ");
		$token = '\'%' . $keyword . '%\'';
		$query->bindValue(1, $keyword);

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
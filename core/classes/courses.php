<?php 
class Courses {
	private $db;

	public function __construct($database) {
		$this->db = $database;
	}

	/**
	 * Check for existing course
	 **/
	public function course_exists($course_id)
	{
		$query = $this->db->prepare("SELECT * FROM `sm_courses` WHERE `course_id` = ?");
		$query->bindValue(1, $course_idr);

		try {
			$query->execute();
			$rows = $query->fetchColum();

			if ($rows == 1) {
				return true;
			} else {
				return false
			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	
}

 ?>
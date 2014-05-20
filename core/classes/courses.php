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

	public function create_course($course_title, $course_code, $course_alias, $cat_id, $course_type, $start_date, $length, $user_id, $school)
	{
		$create_date = time();

		$query = $this->db->prepare("INSERT INTO `sm_courses` (`course_title`, `course_code`, `course_alias`, `cat_id`,`course_type`, `start_date`, `length`, `school`)
									 VALUES (?, ?, ?, ?, ?, ?, ?)");
		$query->bindValue(1, $course_title);
		$query->bindValue(2, $course_code);
		$query->bindValue(3, $course_alias);
		$query->bindValue(4, $cat_id);
		$query->bindValue(5, $course_type);
		$query->bindValue(6, $start_date);
		$query->bindValue(7, $length);
		$query->bindValue(8, $school);

		try {
			$query->execute();

			$id = $this->get_ifa($course_alias);

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

	public function build_structure($course_alias)
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
		file_put_contents($folder . '/progress.php', '<?php $alias = \'' . $course_alias . '\'; require \'../index.php\';?>');
	}

	public function get_enroller($course_id)
	{
		$query = $this->db->prepare("SELECT `user_id`, `username`, `email`, `display_name`, `avatar`, `first_name`, `last_name`, `time`
											  FROM `sm_users`
											  WHERE `user_id` IN (SELECT `user_id`
											  							 FROM `sm_enroll_course`
											  							 WHERE `course_id` = ?)
											  ORDER BY `time`");
		$query->bindValue(1, $course_id);

		try {
			$query->execute();
			return $query->fetchAll();
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function get_num_enroller($course_id)
	{
		$query = $this->db->prepare("SELECT COUNT(`user_id`) FROM `sm_enroll_course` WHERE `course_id` = ?");
		$query->bindValue(1, $course_id);

		try {
			$query->execute();

			return $query->fetchColumn();
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function get_num_exercise($course_id)
	{
		$query = $this->db->prepare("SELECT COUNT(`exercise_id`) FROM `sm_exercises` WHERE `course_id` = ?");
		$query->bindValue(1, $course_id);

		try {
			$query->execute();

			return $query->fetchColumn();
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function enroll($user_id, $course_id)
	{
		$query = $this->db->prepare("INSERT INTO `sm_enroll_course`(`user_id`, `course_id`, `enroll_date`)
											VALUES(?, ?, ?)");
		$query->bindValue(1, $user_id);
		$query->bindValue(2, $course_id);
		$query->bindValue(3, time());

		try {
			$query->execute();

			return true;
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function is_registered($user_id, $course_id)
	{
		$query = $this->db->prepare("SELECT * FROM `sm_enroll_course` WHERE `user_id` = ? AND `course_id` = ?");
		$query->bindValue(1, $user_id);
		$query->bindValue(2, $course_id);

		try {
			$query->execute();
			$row = $query->rowCount();
			if ($row == 1) {
				return true;
			} else {
				return false;
			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}
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

	public function update_photo($course_id, $avatar, $cover)
	{
		$query = $this->db->prepare("UPDATE `sm_courses` SET `course_avatar` = ?, `course_cover` = ? WHERE `course_id` = ?");
		$query->bindValue(1, $avatar);
		$query->bindValue(2, $cover);
		$query->bindValue(3, $course_id);
		
		try {
			$query->execute();
			return true;
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function update_course($course_id,$course_desc, $avatar, $course_cover = '')
	{
		$query = $this->db->prepare("UPDATE `sm_courses` SET `course_desc` = ?,
															 `avatar` = ?,
															 `course_cover' = ?
														WHERE `course_id` = ?");
		$query->bindValue(1, $course_desc);
		$query->bindValue(2, $avatar);
		$query->bindValue(3, $course_cover);
		try {
			$query->execute();
			return true;
		} catch (PDOException $e) {
			return false;
		}
	}

	public function update($course_id, $field, $value)
	{
		$allowed = array('course_title', 'course_desc', 'course_type', 'start_date', 
							  'length', 'course_avatar', 'course_cover', 'school');
		if(!in_array($field, $allowed)) {
			throw new InvalidArgumentException;
		} else {
			$query = $this->db->prepare("UPDATE `sm_courses` SET $field = ? WHERE `course_id` = $course_id");
			// $query->bindParam(':field', $field, PDO::PARAM_STR);
			$query->bindValue(1, $value);
			// $query->bindParam(':course_id', $course_id, PDO::PARAM_INT);

			try {
				$query->execute();
				return true;
			} catch (PDOException $e) {
				die($e->getMessage());
			}
		}
	}

	public function get_course_by_cat($cat_id)
	{
		$query = $this->db->prepare("SELECT * FROM `sm_courses` WHERE `cat_id` = $cat_id");
		try {
			$query->execute();

			return $query->fetchAll();
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function get_all_course_by_cat()
	{
		$results = array();
		$query = $this->db->prepare("SELECT scat.cat_title AS 'title', scat.cat_id AS 'cat_id', COUNT(smc.course_id) AS 'count'
									FROM `sm_courses` AS smc, `sm_course_cat` AS scat
									WHERE smc.cat_id = scat.cat_id
									GROUP BY scat.cat_id, scat.cat_title
									UNION 
									SELECT scat.cat_title AS 'title', scat.cat_id AS 'cat_id', 0 AS 'count'
									FROM `sm_course_cat` AS scat
									WHERE scat.cat_id NOT IN (SELECT DISTINCT cat_id FROM `sm_courses`) ");
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

	public function get_cat_info($what, $field, $value)
	{
		$allowed = array('cat_id', 'cat_title');
		if (!in_array($what, $allowed)) {
			throw new InvalidArgumentException;
		}

		$query = $this->db->prepare("SELECT $what FROM `sm_course_cat` WHERE $field = $value");
		try {
				$query->execute();

				return $query->fetchColumn();
			} catch (PDOException $e) {
				die($e->getMessage());
			}	
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
    
    public function get_teacher($course_id) {
        $query = $this->db->prepare("SELECT * FROM `sm_users` AS smu, `sm_create_course` AS scc WHERE scc.`course_id` = ? AND scc.`user_id` = smu.`user_id`");
        $query->bindValue(1, $course_id);
        
        try {
            $query->execute();
            return $query->fetch();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
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

	public function get_ifa($course_alias)
	{
		$query = $this->db->prepare("SELECT `course_id` FROM `sm_courses` WHERE `course_alias` = ?");
		$query->bindValue(1, $course_alias);

		try {
			$query->execute();
			return $query->fetchColumn();
		} catch (PDOException $e) {
			die($e->getMessage());
		}
		return false;
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

	public function get_unit_video($course_id, $unit_id)
	{
		$query = $this->db->prepare("SELECT `vid_id`,`vid_title`, `vid_link` FROM `sm_units` WHERE `unit_id` = ? AND `course_id` = ?");
		$query->bindValue(1, $unit_id);
		$query->bindValue(2, $course_id);

		try {
			$query->execute();
			return $query->fetchAll();
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function get_video($course_id, $unit_id)
	{
		$query = $this->db->prepare("SELECT `vid_id`, `vid_title`, `vid_link` FROM `sm_units` WHERE `course_id` = ?");
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

	public function get_exercise_by_unit($course_id, $unit_id)
	{
		$query = $this->db->prepare("SELECT * FROM `sm_exercises` WHERE `course_id` = ? AND `unit_id` = ?");
		$query->bindValue(1, $course_id);
		$query->bindValue(2, $unit_id);

		try {
			$query->execute();
			return $query->fetchAll();
		} catch (PDOException $e) {
			die($e->getMessage());
		}
		return false;
	}

	public function get_pending_exercise($user_id, $course_id, $unit_id, $exercise_id)
	{
		$query = $this->db->prepare(" SELECT * 
												FROM sm_do_exercise
												WHERE user_id =?
												AND course_id =?
												AND unit_id =?
												AND answer_text <>  ''
												AND exercise_id =?
												AND IFNULL( approved,  'N' ) <>  'Y'
												AND attempt_made = ( 
												SELECT MAX( attempt_made ) 
												FROM sm_do_exercise
												GROUP BY user_id, course_id, unit_id, exercise_id
												HAVING (
												user_id, course_id, unit_id, exercise_id
												) = ( ?,?,?,? ) )");
		$query->bindValue(1, $user_id);
		$query->bindValue(2, $course_id);
		$query->bindValue(3, $unit_id);
		$query->bindValue(4, $exercise_id);
		$query->bindValue(5, $user_id);
		$query->bindValue(6, $course_id);
		$query->bindValue(7, $unit_id);
		$query->bindValue(8, $exercise_id);

		try {
			$query->execute();
			return $query->fetchALl();
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function search_courses($keyword)
	{
		$token = '\'%' . $keyword . '%\'';
		$results = array();
		$query = $this->db->prepare('SELECT * FROM `sm_courses` WHERE `course_title` LIKE ' . $token . '');
        $query->bindParam(':token', $token, PDO::PARAM_STR);
        
		try {
			$query->execute();
			return $query->fetchAll();
		} catch (PDOException $e) {
			die($e->getMessage());
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
											  ORDER BY `create_date` DESC");
		$query->bindValue(1, $course_id);

		try {
			$query->execute();
			return $query->fetchAll();
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function delete_announcement($course_alias, $anno_id)
	{
		$course_id = $this->get_ifa($course_alias);

		$query = $this->db->prepare("DELETE FROM `sm_course_announcements` WHERE `course_id` = ? AND `anno_id` = ?");
		$query->bindValue(1, $course_id);
		$query->bindValue(2, $anno_id);

		try {
			$query->execute();
			return true;
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
		$query->bindValue(8, $valid_from);		# Convert DateTime back to string before insert to Database
		$query->bindValue(9, $valid_to);		   # Convert DateTime back to string before insert to Database

		try {
			$query->execute();
			return true;
		} catch (PDOException $e) {
			die($e->getMessage());
		}
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

	/*
	 * sm_do_exercises table
	 */
	public function multi_choice_exercise_submit($user_id, $course_id, $unit_id, $exercise_id, $answer_mul = '',
		                                          $answer_text = '', $status = '')
	{
		$query = $this->db->prepare("INSERT INTO `sm_do_exercise`(`user_id`, `course_id`, `unit_id`, `exercise_id`, `answer_mul`,
		                                          `answer_text`, `attempt_made`, `attempt_timestamp`, `status`, `score`, `approved`)							  
		                                          VALUES (?,?,?,?,?,?,?,?,?,?,?)");
		$timestamp = time();
		$attempt = 1 + $this->get_max_attempt_made($user_id, $course_id, $unit_id, $exercise_id);
		$score = null;
		$approved = null;
		if($status != 1) {
			if ($answer_mul != '') {
			
				if ($answer_mul == $this->multi_choice_get_correct_answer($course_id, $unit_id, $exercise_id)) {
					$status = 3;
					$score = $this->get_ex_score($course_id, $unit_id, $exercise_id);
					$approved = 'Y';
				} else {
					$status = 4;
				}
			} else {
				$status = 2;
			}
		}
		$query->bindValue(1, $user_id);
		$query->bindValue(2, $course_id);
		$query->bindValue(3, $unit_id);
		$query->bindValue(4, $exercise_id);
		$query->bindValue(5, $answer_mul);
		$query->bindValue(6, $answer_text);
		$query->bindValue(7, $attempt);
		$query->bindValue(8, $timestamp);
		$query->bindValue(9, $status);
		$query->bindValue(10, $score);
		$query->bindValue(11, $approved);
		try {
			$query->execute();

			return $status;
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function get_ex_score($course_id, $unit_id, $exercise_id)
	{
		$query = $this->db->prepare("SELECT `score` FROM `sm_exercises` WHERE `course_id` = ? AND `unit_id` = ? AND `exercise_id` = ?");
		$query->bindValue(1, $course_id);
		$query->bindValue(2, $unit_id);
		$query->bindValue(3, $exercise_id);

		try {
			$query->execute();

			return $query->fetchColumn();
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function multi_choice_get_correct_answer($course_id, $unit_id, $exercise_id)
	{
		$query = $this->db->prepare("SELECT `question_type`, `correct_answer` FROM `sm_exercises` WHERE `course_id` = ? AND `unit_id` = ? AND `exercise_id` = ?");
		$query->bindValue(1, $course_id);
		$query->bindValue(2, $unit_id);
		$query->bindValue(3, intval($exercise_id));

		try {
			$query->execute();

			$question_type = $query->fetch();

			if ($question_type['question_type'] == 1) {
				return $question_type['correct_answer'];
			} else {
				return '';
			}

		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function get_max_attempt_made($user_id, $course_id, $unit_id, $exercise_id)
	{
		$query = $this->db->prepare("SELECT IFNULL(MAX(`attempt_made`), 0) FROM `sm_do_exercise` WHERE `user_id` = ?
																														 AND   `course_id` = ? 
																														 AND   `unit_id` = ?
																														 AND   `exercise_id` = ?");
		$query->bindValue(1, $user_id);
		$query->bindValue(2, $course_id);
		$query->bindValue(3, $unit_id);
		$query->bindValue(4, intval($exercise_id));

		try {
			$query->execute();

			return $query->fetchColumn();
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
    
    public function unit_count($course_id) {
        $query = $this->db->prepare("SELECT COUNT(`unit_id`) FROM `sm_units` WHERE `course_id` = ? GROUP BY `course_id`");   
        $query->bindValue(1, $course_id);
        
        try {
            $query->execute();
            return $query->fetchColumn();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    
	public function get_max_course_id() 
	{
		$query = $this->db->prepare("SELECT IFNULL(MAX(`course_id`), 0) FROM `sm_courses`");

		try {
			$query->execute();
			return $query->fetchColumn();
		} catch (PDOException $e) {
			die($e->getMessage());
		}
		return false;
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

	public function get_max_announcement_id($course_id)
	{
		$query = $this->db->prepare("SELECT IFNULL(MAX(`anno_id`), 0) FROM `sm_course_announcements` WHERE `course_id` = ?");
		$query->bindValue(1, $course_id);

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
		$query = $this->db->prepare("SELECT * FROM `sm_exercises` WHERE `course_id` = ?");
		$query->bindValue(1, $course_id);

		try {
			$query->execute();
			return $query->fetchAll();
		} catch (PDOException $e) {
			die($e->getMessage());
		}
		return false;
	}

	public function get_all_unit_exercise($course_id, $unit_id)
	{
		$query = $this->db->prepare("SELECT * FROM `sm_exercises` WHERE `course_id` = ? AND `unit_id` = ?");
		$query->bindValue(1, $course_id);
		$query->bindValue(2, $unit_id);

		try {
			$query->execute();
			return $query->fetchAll();
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function get_max_message_id()
	{
		$query = $this->db->prepare("SELECT IFNULL(MAX(`message_id`),0) FROM `sm_messages`");
		$query->execute();
		return $query->fetchColumn();
	}

	public function create_message($subject, $message)
	{
		$query = $this->db->prepare("INSERT INTO `sm_messages`(`message_id`, `subject`, `message`)
											  VALUES(?,?,?)");
		$message_id = 1 + $this->get_max_message_id();
		$query->bindValue(1, $message_id);
		$query->bindValue(2, $subject);
		$query->bindValue(3, $message);

		try {
			$query->execute();
			return $message_id;
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function send_message($sender_id, $receiver_id, $subject, $message)
	{
		$message_id = $this->create_message($subject, $message);

		$query = $this->db->prepare("INSERT INTO `sm_send_message`(`sender_id`, `receiver_id`, `message_id`, `status`, `timestamp`)
																				VALUES(?,?,?,?,?)");
		$query->bindValue(1, $sender_id);
		$query->bindValue(2, $receiver_id);
		$query->bindValue(3, $message_id);
		$query->bindValue(4, 'pending');
		$query->bindValue(5, time());

		try {
			$query->execute();
			return true;
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}
}
 ?>
<?php 
class Users {
	private $db;

	public function __construct($database) {
		$this->db = $database;
	}

	/*
	 * Check for existing user
	 */
	public function user_exists($username) {
		$query = $this->db->prepare("SELECT COUNT(`user_id`) FROM `sm_users` WHERE `username` = ?");
		$query->bindValue(1, $username);

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

	public function email_exists($email)
	{
		$query = $this->db->prepare("SELECT COUNT(`user_id`) FROM `sm_users` WHERE `email` = ?");
		$query->bindValue(1, $email);

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

	public function register($username, $password, $email)
	{
		# Make bcrypt global so that we can use it here
		global $bcrypt;
		$time 		= time();
		$ip	  		= $_SERVER['REMOTE_ADDR'];
		#$email_code = sha1($username + microtime());
		$email_code = uniqid('code_', true);
		#$password	= sha1($password);
		$password 	= $bcrypt->genHash($password);

		$query = $this->db->prepare("INSERT INTO `sm_users` (`username`, `password`, `email`, `email_code`, `ip`, `time`) VALUES (?, ?, ?, ?, ?, ?)");

		$query->bindValue(1, $username);
		$query->bindValue(2, $password);
		$query->bindValue(3, $email);
		$query->bindValue(4, $email_code);
		$query->bindValue(5, $ip);
		$query->bindValue(6, $time);

		try {
			$query->execute();

			mail($email, 'Please activate your account', "Hello " . $username. ",\r\nThank you for registering with us. Please visit the link below so we can activate your account:\r\n\r\nlocalhost/smartcourse/activate.php?email=" . $email . "&email_code=" . $email_code . "\r\n\r\n-- Example team");

		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function activate($email, $email_code)
	{
		$query = $this->db->prepare("SELECT COUNT(`user_id`) FROM `sm_users` WHERE `email` = ? AND `email_code` = ? AND `confirmed` = ?");

		$query->bindValue(1, $email);
		$query->bindValue(2, $email_code);
		$query->bindValue(3, 0);

		try {
			$query->execute();
			$rows = $query->fetchColumn();

			if ($rows == 1) {
				
				$up_query = $this->db->prepare("UPDATE `sm_users` SET `confirmed` = ? WHERE `email` = ?");
				$up_query->bindValue(1, 1);
				$up_query->bindValue(2, $email);

				$up_query->execute();
				return true;
			} else {
				return false;
			}

		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function login($username, $password)
	{
		global 	$bcrypt;

		$query = $this->db->prepare("SELECT `password`, `user_id` FROM `sm_users` WHERE `username` = ?");
		$query->bindValue(1, $username);

		try {
			
			$query->execute();
			$data   = $query->fetch();
			$stored_password = $data['password'];
			$id = $data['user_id'];

			# hashing supplied password
			#if ($stored_password === sha1($password)) {
			if ($bcrypt->verify($password, $stored_password)) {
				return $id;
			} else {
				return false;
			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function email_confirmed($username)
	{
		$query = $this->db->prepare("SELECT COUNT(`user_id`) FROM `sm_users` WHERE `username` = ? AND `confirmed` = ?");
		$query->bindValue(1, $username);
		$query->bindValue(2, 1);

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

	public function userdata($id)
	{
		$query = $this->db->prepare("SELECT * FROM `sm_users` WHERE `user_id` = ?");
		$query->bindValue(1, $id);

		try {
			$query->execute();

			return $query->fetch();

		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function fetch_info($what, $field, $value) 	
	{
		$allowed = array('user_id', 'username', 'first_name', 'last_name', 'gender',
						 'bio', 'role', 'display_name', 'email', 'birthday', 'avatar');
		if (!in_array($what, $allowed, true) || !in_array($field, $allowed, true)) {
			throw new InvalidArgumentException;
		} else {

			$query = $this->db->prepare("SELECT $what FROM `sm_users` WHERE $field = ?");
			$query->bindValue(1, $value);

			try {
				$query->execute();
			} catch (PDOException $e) {
				die($e->getMessage());
			}

			return $query->fetchColumn();
		}
	}

	public function confirm_recover($email)
	{
		$username = $this->fetch_info('username', 'email', $email);

		$unique = uniqid('', true);			// generate a unique string
		$random = substr(str_shuffle('ABCDEFGHIKLMNOPQRSTUVXWZ'), 0, 10);

		$generated_string - $unique .$random;

		$query = $this->db->prepare("UPDATE `sm_users` SET `generated_string` = ? WHERE `email` = ?");
		$query->bindValue(1, $generated_string);
		$query->bindValue(2, $email);

		try {
			$query->execute();

			mail($email, 'Recover Password', "Hello " . $username. ",\r\nPlease click the link below:\r\n\r\nhttp://localhost/smartcourse/recover.php?email=" . $email . "&generated_string=" . $generated_string . "\r\n\r\n We will generate a new password for you and send it back to your email.\r\n\r\n-- Smartcourse Team");	
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function recover($email, $generated_string)
	{
		
		if($generated_string == 0) {
			return false;
		}else {

			$query = $this->db->prepare("SELECT COUNT(`user_id`) FROM `sm_users` WHERE `email` = ? AND `generated_string` = ?");
			$query->bindValue(1, $email);
			$query->bindValue(2, $generated_string);

			try {
				$query->execute();
				$rows = $query->fetchColumn();

				if ($rows == 1) {
					global $bcrypt;

					$username = $this->fetch_info('username', 'email', $email);
					$user_id = $this->fetch_info('user_id', 'email', $email);


					$charset = 'abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
					$generated_password = substr(str_shuffle($charset), 0, 10);

					$this->change_password($user_id, $generated_password);

					# reset generated_string back to 0
					$query = $this->db->prepare("UPDATE `sm_users` SET `generated_string` = 0 WHERE `user_id` = ?");
					$query->bindValue(1, $user_id);

					$query->execute();

					mail($email, 'Your password', "Hello " . $username . ",\n\nYour your new password is: " . $generated_password . "\n\nPlease change your password once you have logged in using this password.\n\n--Smartcourse Team");

				} else {
					return false;
				}
			} catch (PDOException $e) {
				die($e->getMessage());
			}
		}
	}

	public function change_password($user_id, $password)
	{
		global $bcrypt;

		$password_hash = $bcrypt->genHash($password);

		$query = $this->db->prepare("UPDATE `sm_users` SET `password` = ? WHERE `user_id` = ?");
		$query->bindValue(1, $password_hash);
		$query->bindValue(2, $user_id);

		try {
			$query->execute();
			return true;
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function update_user($user_id, $first_name, $last_name, $bio, $display_name, $avatar)
	{
		$query = $this->db->prepare("UPDATE `sm_users` SET
										   `first_name`   = ? ,
										   `last_name`    = ? ,
										   `bio`		  = ? ,
										   `display_name` = ? ,
										   `avatar`		  = ?
									WHERE  `user_id`	  = ?");
		$query->bindValue(1, $first_name);
		$query->bindValue(2, $last_name);
		$query->bindValue(3, $bio);
		$query->bindValue(4, $display_name);
		$query->bindValue(5, $avatar);
		$query->bindValue(6, $user_id);

		try {
			$query->execute();
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}
 }
 
 ?>

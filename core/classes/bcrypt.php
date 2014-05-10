<?php 
/**
 * BCrypt method - used as alternative for normal hash and md5
 * 
 * Author: duccuongict
 * Last update: 02-May-2014 14:52 
 **/
class Bcrypt {
	private $rounds;
	public function __construct($rounds = 12) {
		if (CRYPT_BLOWFISH != 1) {
			throw new Exception("Bcrypt is not supported on this server");
		}
		$this->rounds = $rounds;
	}

	/* Gen Salt*/
	private function genSalt() {
		$string = str_shuffle(mt_rand());
		$salt 	= uniqid($string, true);

		return $salt;
	}

	/* Gen Hash */
	public function genHash($password)
	{
		$hash = crypt($password, '$2y$' . $this->rounds . '$' . $this->genSalt());

		return $hash;
	}

	/* Verify password */
	public function verify($password, $existingHash)
	{
		$hash = crypt($password, $existingHash);

		if ($hash === $existingHash) {
			return true;
		} else {
			return false;
		}
	}
}

 ?>
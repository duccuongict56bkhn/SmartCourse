<?php 

# Starting the users session
session_start();

#error_reporting(E_ALL | E_STRICT);

require 'connect/db.php';
require 'classes/users.php';
require 'classes/general.php';
require 'classes/bcrypt.php';
require 'classes/courses.php';
require 'classes/UploadHandler.php';

$users		= new Users($db);
$general		= new General();
$bcrypt 		= new Bcrypt();
$courses		= new Courses($db);
#$upload_handler = new UploadHandler();

if ($general->logged_in() === true)  { // check if the user is logged in
	$user_id 	= $_SESSION['user_id']; // getting user's id from the session.
	$user 	= $users->userdata($user_id); // getting all the data about the logged in user.
}

$errors			= array();
#date_default_timezone_set('Asia/Jakarta');
 ?>
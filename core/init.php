<?php 

# Starting the users session
session_start();

require 'connect/db.php';
require 'classes/users.php';
require 'classes/general.php';
require 'classes/bcrypt.php';
require 'classes/courses.php';

$users		= new Users($db);
$general		= new General();
$bcrypt 		= new Bcrypt();
$courses		= new Courses($db);

if ($general->logged_in() === true)  { // check if the user is logged in
	$user_id 	= $_SESSION['user_id']; // getting user's id from the session.
	$user 	= $users->userdata($user_id); // getting all the data about the logged in user.
}

$errors			= array();
 ?>
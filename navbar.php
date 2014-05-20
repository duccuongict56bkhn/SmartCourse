<?php #require 'core/init.php'; 
$filename = basename($_SERVER['SCRIPT_NAME']);
$page_title = ucfirst(substr($filename, 0, strpos($filename, '.php')));

?>

<!DOCTYPE html>
<html lang="en" charset="utf8">
<head>
	<title>StudyHub | <?php echo $page_title;?></title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/prettify.css">
	<link rel="stylesheet" type="text/css" href="css/dashboard.css">
	<link rel="stylesheet" type="text/css" href="css/datepicker.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-select/bootstrap-select.css">
	<link rel="stylesheet" type="text/css" href="bseditable/css/bootstrap-editable.css">
	<link rel="shortcut icon" href="images/icon.ico">
   <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800&subset=latin,vietnamese' rel='stylesheet' type='text/css'>
	<script src="js/jquery-2.1.0.min.js"></script>
	<script src="js/jquery.validate.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/ajax.js"></script>
	<script src="js/prettify.js"></script>
	<script src="css/bootstrap-select/bootstrap-select.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/readmore.min.js"></script>
	<script type="text/javascript" src="magic.js"></script>
	<script src="bseditable/js/bootstrap-editable.js"></script>
	<?php if ($page_title == 'Editannouncement'): ?>
		<link rel="stylesheet" type="text/css" href="css/bootstrap-notify/css/bootstrap-notify.css">
		<link rel="stylesheet" type="text/css" href="css/bootstrap-notify/css/styles/alert-blackgloss.css">
		<script type="text/javascript" src="css/bootstrap-notify/js/bootstrap-notify.js"></script>
	<?php endif ?>
	<link rel="stylesheet" type="text/css" href="jasny-bootstrap/css/jasny-bootstrap.min.css">
	<script type="text/javascript" src="jasny-bootstrap/js/jasny-bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-default navbar-fixed-top navbar-inverse" role="navigation">
	<div class="container-fluid">

		<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="index.php" class="navbar-brand">StudyHub</a>
		</div>

		<div class="collapse navbar-collapse" id="navbar-collapse-1">
			<ul class="nav navbar-nav">
				<?php 
				if (basename($_SERVER['PHP_SELF']) == 'courses.php') {
				 ?>
				<li>
					<a href="courses.php" class="active">Courses</a>
				</li>
				<?php } else { ?>
				<li>
					<a href="courses.php">Courses</a>
				</li>
				<?php } ?>
				<!-- <li><a href="#">FAQ</a></li> -->
				<li><a href="about.php">About</a></li>
				<li><a href="#">Terms of services</a></li>
				<li><a href="#">Contact</a></li>
			</ul>

			<ul class="nav navbar-nav navbar-right">
			<?php 
			if ($general->logged_in()) {
				if ($users->get_role($user['user_id']) == 'Teacher') { ?>
			
				<li><a href="createcourse.php"><span class="glyphicon glyphicon-plus"></span>Create a new course</a></li>
			<?php  } }?>
			<?php 
			if ($general->logged_in()) { $image = $user['avatar']; ?>
				<li>
					<div class="avatar">
						<?php if(!empty($image)) { ?>
							<img src="<?php echo $image; ?>" alt="">
							<?php } else { ?>
						<img src="images/avatars/default_avatar.png" alt="">
						<?php } ?>
					</div>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><strong><?php echo $user['username']; ?></strong><b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="course.php?username=<?php echo $user['username'];?>"><span class="glyphicon glyphicon-list"></span>My courses</a></li>
						<li><a href="profile.php?username=<?php echo $user['username'];?>"><span class="glyphicon glyphicon-user"></span>My profile</a></li>
						<li><a href="settings.php?username=<?php echo $user['username'];?>""><span class="glyphicon glyphicon-wrench"></span>Settings</a></li>
						<li><a href="signout.php"><span class="glyphicon glyphicon-off"></span>Sign out</a></li>
					</ul>
				</li>
			<?php } else { ?>
				<li><a href="signup.php">Sign up</a></li>
				<li><a href="signin.php">Sign in</a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
</nav>
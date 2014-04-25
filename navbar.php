<?php require 'core/init.php'; ?>

<!DOCTYPE html>
<html lang="en" charset="utf8">
<head>
	<title>Smartcourse | Homepage </title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/prettify.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-select.css">
	<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900' rel='stylesheet' type='text/css'>
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
				<a href="index.php" class="navbar-brand">Smartcourse</a>
		</div>

		<div class="collapse navbar-collapse" id="navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li class="active dropdown">
					<a href="index.php" class="dropdown-toggle" data-toggle="dropdown">Courses <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="#">Computer Science</a></li>
						<li><a href="#">Literature</a></li>
						<li><a href="#">Electrical Engineering</a></li>
						<li><a href="#">Biomedical Engineering</a></li>
						<li><a href="#">Economics &amp; Finance</a></li>
						<li><a href="#">Humanities</a></li>
					</ul>
				</li>
				<li><a href="#">FAQ</a></li>
				<li><a href="#">About</a></li>
				<li><a href="#">Terms of services</a></li>
				<li><a href="#">Contact</a></li>
			</ul>

			<ul class="nav navbar-nav navbar-right">
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
						<li><a href="course.php?username=<?php echo $user['username'];?>">My courses</a></li>
						<li><a href="profile.php?username=<?php echo $user['username'];?>">My profile</a></li>
						<li><a href="settings.php">Settings</a></li>
						<li><a href="signout.php">Log out</a></li>
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
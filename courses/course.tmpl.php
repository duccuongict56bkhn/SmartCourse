<?php 
$title = $course_data['course_title'];
$filename = basename($_SERVER['SCRIPT_NAME']);
$is_teacher = ($user['role'] == 2) ? true : false;
$is_owner   = $courses->is_created_by_me($user['user_id'], $id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>StudyHub | <?php echo $title; ?></title>
	<!-- Global CSS-->
	<link rel="stylesheet" href="../../css/bootstrap.css">
	<link rel="stylesheet" href="../../css/prettify.css">
	<!-- CSS for course page-->
	<link rel="stylesheet" href="../course.css">
	<link rel="stylesheet" href="../../css/dashboard.css">
	<link rel="stylesheet" href="../../css/datepicker.css">
	<link rel="stylesheet" type="text/css" href="../../css/bootstrap-select/bootstrap-select.css">
</head>
<body>
<!-- Navbar-->
<nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
				<span class="sr-only">Toggle Navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="../../index.php" class="navbar-brand">StudyHub</a>
		</div>

		<div class="collpase navbar-collapse" id="navbar-collapse">
			<ul class="nav navbar-nav">
				<li>
					<a style="color: #eee; font-weight: bold;"><?php echo $course_data['course_title']; ?></a>
				</li>
			</ul>

			<ul class="nav navbar-nav navbar-right">
				<?php 
				if ($general->logged_in()) {
					# if he/she creates the course, he/she can edit its content
					if ($users->get_role($user['user_id']) == 'Teacher' && $courses->is_created_by_me($user['user_id'], $id) === true) { 
						# Show the edit, create menu ?>
						<li class="drowndown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" id="option-btn">
								<div class="btn-group">
									<button type="button" class="btn btn-primary btn-sm">Option <b class="caret"></b></button>
								</div>
							</a>
							<ul class="dropdown-menu" role="menu">
								<li role="representation" class="dropdown-header">Edit course</li>
								<li>
									<a href="#">Add new unit</a>
									<a href="#">Add new announcement</a>
									<a href="#">Add new materials</a>
								</li>
								<li role="representation" class="divider"></li>
								<li role="representation" class="dropdown-header">Create course</li>
								<li>
									<a href="../../createcourse.php">Create a new course</a>
								</li>
							</ul>
						</li>
					<?php } else { ?>
						<!--Show the course_register-->
						<li>
							<a href="#" id="register-btn">
								<button class="btn btn-primary btn-sm">Register for this course</button>
							</a>
						</li>
					<?php } # get_role() 
						# Show normal menu for logged in users ?>
						<li>
							<div class="avatar">
								<?php if (!empty($user['avatar'])) { ?>
									<img src="../../<?php echo $user['avatar'];?>" alt="User avatar" ?>
								<?php } ?>
							</div>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><strong><?php echo $user['display_name']; ?></strong><b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="../../course.php?username=<?php echo $user['username'];?>"><span class="glyphicon glyphicon-list"></span>My courses</a></li>
								<li><a href="../../profile.php?username=<?php echo $user['username'];?>"><span class="glyphicon glyphicon-user"></span>My profile</a></li>
								<li><a href="../../settings.php"><span class="glyphicon glyphicon-wrench"></span>Settings</a></li>
								<li><a href="../../signout.php"><span class="glyphicon glyphicon-off"></span>Sign out</a></li>
							</ul>
						</li>
				<?php } else {	?>	# user need to first signin to register for this course
					<li><a href="../../signup.php">Sign up</a></li>
					<li><a href="../../signin.php">Sign in</a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
</nav>
<!-- End of .navbar-->

<!-- Main content-->
<div class="container admin-panel">
	<div class="row">
		<div class="col-sm-3 col-md-2 sidebar">
			<img src="../../images/courses/database-thumbnail.png" class="sidebar-logo">
			<ul class="nav nav-sidebar">
				<!-- Dynamically create active section based on what page we are in-->
				<?php if ($filename == 'index.php') {?>
				<li><a href="index.php" class="active"><span class="glyphicon glyphicon-home"></span>Home</a></li>
				<?php } else { ?>
				<li><a href="index.php"><span class="glyphicon glyphicon-home"></span>Home</a></li>
				<?php }?>
				<?php if ($filename == 'lecture.php') {?>
				<li><a class="active" href="lecture.php"><span class="glyphicon glyphicon-film"></span>Video Lectures</a></li>
				<?php } else { ?>
				<li><a href="lecture.php"><span class="glyphicon glyphicon-film"></span>Video Lectures</a></li>
				<?php }?>
				<?php if ($filename == 'exercise.php') {?>
				<li><a class="active" href="exercise.php?course=<?php echo $course_data['course_alias']; ?>"><span class="glyphicon glyphicon-tasks"></span>Exercises</a></li>
				<?php } else { ?>
				<li><a href="exercise.php?course=<?php echo $course_data['course_alias']; ?>"><span class="glyphicon glyphicon-tasks"></span>Exercises</a></li>
				<?php }?>
				<li class="spacer"></li>
				<?php if ($filename == 'syllabus.php') {?>
				<li><a class="active" href="syllabus.php?course=<?php echo $course_data['course_alias']; ?>"><span class="glyphicon glyphicon-pencil"></span>Syllabus</a></li>
				<?php } else { ?>
				<li><a href="syllabus.php?course=<?php echo $course_data['course_alias']; ?>"><span class="glyphicon glyphicon-pencil"></span>Syllabus</a></li>
				<?php }?>
				<?php if ($filename == 'forum.php') {?>
				<li><a class="active" href="forum.php?course=<?php echo $course_data['course_alias']; ?>"><span class="glyphicon glyphicon-screenshot"></span>Discussion Forum</a></li>
				<?php } else { ?>
				<li><a href="forum.php?course=<?php echo $course_data['course_alias']; ?>"><span class="glyphicon glyphicon-screenshot"></span>Discussion Forum</a></li>
				<?php }?>
				<li class="spacer"></li>
				<?php if ($is_teacher && $is_owner): ?>
					<?php if ($filename == 'studentlist.php'): ?>
						<li><a class="active" href="studentlist.php"><span class="glyphicon glyphicon-list"></span>Student list</a></li>
					<?php else : ?>
						<li><a href="studentlist.php"><span class="glyphicon glyphicon-list"></span>Student list</a></li>
					<?php endif ?>
				<?php endif ?>
				<?php if ($filename == 'about.php') {?>
				<li><a href="about.php?course=<?php echo $course_data['course_alias']; ?>"><span class="glyphicon glyphicon-user"></span>Course staff</a></li>
				<?php } else { ?>
				<li><a href="about.php?course=<?php echo $course_data['course_alias']; ?>"><span class="glyphicon glyphicon-user"></span>Course staff</a></li>
				<?php }?>
			</ul>
		</div> <!-- End of .sidebar-->

		<!-- Content for each page - depends on which page we are in-->
		<?php if ($filename == 'index.php'): ?>		
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main-content">
			<div class="row announcement">
			<div class="col-lg-12 col-md-12" style="padding-left: 0; padding-right: 0;">
				<h2 class="page-header">Announcements</h2>
				<div class="pull-right">
					<a href="#" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-flash"></span>Create new</a>
				</div>
			</div>
						<!-- Announcement holder-->
			<div class="col-lg-12 col-md-12" >
				<?php foreach ($annos as $anno) { ?>
					<div class="row">
						<?php if ($anno['anno_type'] == '1'): ?>
							<div class="panel panel-default">
								<div class="panel-heading">
									<span class="panel-title"><strong><?php echo $anno['anno_title'] ?></strong></span>
									<span class="label label-default pull-right"><?php echo $anno['valid_from'] . ' - ' . $anno['valid_to']; ?></span>
								</div>
								<div class="panel-body">
									<?php echo $anno['anno_content']; ?>
								</div>
							</div>
						<?php endif ?>
						<?php if ($anno['anno_type'] == '2'): ?>
							<div class="panel panel-warning">
								<div class="panel-heading">
									<span class="panel-title"><strong><?php echo $anno['anno_title'] ?></strong></span>
									<span class="label label-warning pull-right"><?php echo $anno['valid_from'] . ' - ' . $anno['valid_to']; ?></span>
								</div>
								<div class="panel-body">
									<?php echo $anno['anno_content']; ?>
								</div>
							</div>
						<?php endif ?>
						<?php if ($anno['anno_type'] == '3'): ?>
							<div class="panel panel-danger">
								<div class="panel-heading">
									<span class="panel-title"><strong><?php echo $anno['anno_title'] ?></strong></span>
									<span class="label label-danger pull-right"><?php echo $anno['valid_from'] . ' - ' . $anno['valid_to']; ?></span>
								</div>
								<div class="panel-body">
									<?php echo $anno['anno_content']; ?>
								</div>
							</div>
						<?php endif ?>
					</div>
				<?php } ?>
			</div>
			</div>
		</div>
		<?php endif ?>

		<!-- For lecture.php-->
		<?php if ($filename == 'lecture.php'): ?>

		<?php endif ?>		
		<!-- End lecture.php-->
	</div>
</div>
<!-- End .main content -->
<!-- Javascript-->
<script src="../../js/jquery-2.1.0.min.js"></script>
<script src="../../js/bootstrap.js"></script>
<script src="../../js/prettify.js"></script>
<script src="../../js/bootstrap-datepicker.js"></script>
<script src="../../js/bootstrap-select.js"></script>
<script type="text/javascript">
 $(document).ready(function(e) {
     $('.selectpicker').selectpicker();
 });
</script>
</body>
</html>
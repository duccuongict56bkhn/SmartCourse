<?php 
require '../core/init.php'; 
$filename = basename($_SERVER['SCRIPT_NAME']);
$page_title = ucfirst(substr($filename, 0, strpos($filename, '.php')));

$course_alias = $_GET['course'];
$course_id = $courses->get_ifa($course_alias);
$course_title = $courses->get_info('course_title', 'course_id', $course_id);

if (!empty($_POST['course_id']) && !empty($_POST['enroll_date'])) {
	$co_id = $_POST['course_id'];

	$flag = $courses->enroll($user_id, $co_id);

	if ($flag === true) {
		return http_response_code(200);
	} else {
		return http_response_code(400);
	}
}
?>

<!DOCTYPE html>
<html lang="en" charset="utf8">
<head>
	<title>StudyHub | <?php echo $page_title;?></title>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../css/prettify.css">
	<link rel="stylesheet" type="text/css" href="../css/dashboard.css">
	<link rel="stylesheet" type="text/css" href="../css/datepicker.css">
	<link rel="stylesheet" type="text/css" href="../css/bootstrap-select/bootstrap-select.css">
	<link rel="stylesheet" type="text/css" href="../bseditable/css/bootstrap-editable.css">
	<link rel="shortcut icon" href="../images/icon.ico">
   <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800&subset=latin,vietnamese' rel='stylesheet' type='text/css'>
	<script src="../js/jquery-2.1.0.min.js"></script>
	<script src="../js/bootstrap.js"></script>
	<script src="../js/ajax.js"></script>
	<script src="../js/prettify.js"></script>
	<script src="../css/bootstrap-select/bootstrap-select.js"></script>
	<script src="../js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="magic.js"></script>
	<script src="../bseditable/js/bootstrap-editable.js"></script>
	<?php if ($page_title == 'Editannouncement'): ?>
		<link rel="stylesheet" type="text/css" href="css/bootstrap-notify/css/bootstrap-notify.css">
		<link rel="stylesheet" type="text/css" href="css/bootstrap-notify/css/styles/alert-blackgloss.css">
		<script type="text/javascript" src="css/bootstrap-notify/js/bootstrap-notify.js"></script>
	<?php endif ?>
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
					<a href="../courses.php">Courses</a>
				</li>
				<?php } ?>
				<li><a href="#">FAQ</a></li>
				<li><a href="#">About</a></li>
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
							<img src="../<?php echo $image; ?>" alt="">
							<?php } else { ?>
						<img src="../images/avatars/default_avatar.png" alt="">
						<?php } ?>
					</div>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><strong><?php echo $user['username']; ?></strong><b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="../course.php?username=<?php echo $user['username'];?>"><span class="glyphicon glyphicon-list"></span>My courses</a></li>
						<li><a href="../profile.php?username=<?php echo $user['username'];?>"><span class="glyphicon glyphicon-user"></span>My profile</a></li>
						<li><a href="../settings.php"><span class="glyphicon glyphicon-wrench"></span>Settings</a></li>
						<li><a href="../signout.php"><span class="glyphicon glyphicon-off"></span>Sign out</a></li>
					</ul>
				</li>
			<?php } else { ?>
				<li><a href="../signup.php">Sign up</a></li>
				<li><a href="../signin.php">Sign in</a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
</nav>

<div class="container" style="margin-top: 15px;">
	<h2>Welcome <?php echo $user['first_name']; ?>,</h2>
	<h4>You are about to register for <?php echo $course_title; ?>, please read and accept the following constraints</h4>
	<p>
		All students participating in the class must agree to abide by the following code of conduct:
	</p>
	<ol>
		<li>I will register for only one account.</li>
		<li>My answers to homework, quizzes and exams will be my own work (except for assignments that explicitly permit collaboration).</li>
		<li>I will not make solutions to homework, quizzes or exams available to anyone else. This includes both solutions written by me, as well as any official solutions provided by the course staff.</li>
		<li>I will not engage in any other activities that will dishonestly improve my results or dishonestly improve/hurt the results of others.</li>
	</ol>

	<div style="text-align: center;">
		<button style="margin: auto;" class="btn btn-success" id="btnAgree">I agree</button>
	</div>
</div>
</body>
<script type="text/javascript">
	$('#btnAgree').click(function(e) {
		e.preventDefault();

		var user_id = '<?php echo $user_id; ?>';
		var course_id = '<?php echo $course_id ?>';
		var enroll_date = '<?php echo time(); ?>';

		$.ajax({
			type : 'POST',
			url  : 'register.php',
			data : {
				user_id : user_id,
				course_id : course_id,
				enroll_date : enroll_date
			},
			success : function(e) {
				window.location.replace('http://localhost/studyhub/courses/<?php echo $course_alias ?>/');
			}
		});
	})
</script>
</html>
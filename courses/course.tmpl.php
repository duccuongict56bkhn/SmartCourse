<?php 
$title = $course_data['course_title'];
$course_id = $course_data['course_id'];
$filename = basename($_SERVER['SCRIPT_NAME']);
if ($general->logged_in()) {
	$is_teacher = ($users->get_role($user_id) == 'Teacher') ? true : false;
	$is_owner   = $courses->is_created_by_me($user_id, $course_id);
	$is_registered = $courses->is_registered($user_id, $course_id);
} else {
	header('Location: ../../signin.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>StudyHub | <?php echo $title; ?></title>
	<!-- Global CSS-->
	<link rel="stylesheet" href="../../css/bootstrap.css">
	<link rel="stylesheet" href="../../css/prettify.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800&subset=latin,vietnamese' rel='stylesheet' type='text/css'>
	<!-- CSS for course page-->
	<link rel="stylesheet" href="../course.css">
	<link rel="stylesheet" href="../../css/dashboard.css">
	<link rel="stylesheet" href="../../css/datepicker.css">
	<link rel="stylesheet" type="text/css" href="../../css/bootstrap-select/bootstrap-select.css">
	<script src="../../js/jquery-2.1.0.min.js"></script>
	<script src="../../js/bootstrap.js"></script>
	<script src="../../js/prettify.js"></script>
	<script src="../../js/bootstrap-datepicker.js"></script>
	<script src="../../js/bootstrap-select.js"></script>

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
									<button type="button" class="btn btn-primary btn-sm">Tools <b class="caret"></b></button>
								</div>
							</a>
							<ul class="dropdown-menu" role="menu">
								<li role="representation" class="dropdown-header">Edit course</li>
								<li>
									<a href="#">Add new unit</a>
									<a href="../../editannouncement.php?course_alias=<?php echo $course_data['course_alias']; ?>#creat_anno">Add new announcement</a>
									<a href="#">Add new materials</a>
								</li>
								<li role="representation" class="divider"></li>
								<li role="representation" class="dropdown-header">Exercises</li>
								<li>
									<a id="open-new-ex" target="_blank" href="../../newexercise.php?mode=create&amp;course=<?php echo $course_data['course_alias']; ?>">Create new exercise</a>
								</li>
								<li>
									<a href="studentsubmit.php?auth_mode=correct&amp;user_id=<?php echo $user_id ?>&amp;course_alias=<?php echo $course_data['course_alias']; ?>">Correct student's submits</a>
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
						<?php if (!$is_registered): ?>
							<li>
								<a href="../../courses/register.php?user_id=<?php echo $user['user_id'] ?>&amp;course=<?php echo $course_data['course_alias']; ?>&amp;timestamp=<?php echo time(); ?>" id="register-btn">
									<button class="btn btn-primary btn-sm">Register for this course</button>
								</a>
							</li>
						<?php endif ?>
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
				<?php } else {	?>
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
			<img src="../../<?php echo $course_data['course_avatar']; ?>" class="sidebar-logo">
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
				<li><a class="active" href="exercise.php"><span class="glyphicon glyphicon-tasks"></span>Exercises</a></li>
				<?php } else { ?>
				<li><a href="exercise.php"><span class="glyphicon glyphicon-tasks"></span>Exercises</a></li>
				<?php }?>
				<li class="spacer"></li>
				<?php if ($filename == 'syllabus.php') {?>
				<li><a class="active" href="syllabus.php"><span class="glyphicon glyphicon-pencil"></span>Syllabus</a></li>
				<?php } else { ?>
				<li><a href="syllabus.php"><span class="glyphicon glyphicon-pencil"></span>Syllabus</a></li>
				<?php }?>
				<?php if ($filename == 'forum.php') {?>
				<li><a class="active" href="forum.php"><span class="glyphicon glyphicon-screenshot"></span>Discussion Forum</a></li>
				<?php } else { ?>
				<li><a href="forum.php"><span class="glyphicon glyphicon-screenshot"></span>Discussion Forum</a></li>
				<?php }?>
				<li class="spacer"></li>
				<?php if ($is_teacher && $is_owner): ?>
					<?php if ($filename == 'studentlist.php'): ?>
						<li><a class="active" href="studentlist.php"><span class="glyphicon glyphicon-list"></span>Student list</a></li>
					<?php else : ?>
						<li><a href="studentlist.php"><span class="glyphicon glyphicon-list"></span>Student list</a></li>
					<?php endif ?>
					<?php if ($filename == 'studentsubmit.php'): ?>
						<li><a class="active" href="studentsubmit.php"><span class="glyphicon glyphicon-circle-arrow-up"></span>Student submittals</a></li>
					<?php else : ?>
						<li><a href="studentsubmit.php"><span class="glyphicon glyphicon-circle-arrow-up"></span>Student submittals</a></li>
					<?php endif ?>
				<?php endif ?>
				<li class="spacer"></li>
				<?php if ($filename == 'about.php') {?>
				<li><a href="about.php"><span class="glyphicon glyphicon-user"></span>Course staff</a></li>
				<?php } else { ?>
				<li><a href="about.php"><span class="glyphicon glyphicon-user"></span>Course staff</a></li>
				<?php }?>
			</ul>
		</div> <!-- End of .sidebar-->

		<!-- Content for each page - depends on which page we are in-->
		<?php if ($filename == 'index.php'): ?>		
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main-content">
			<div class="row announcement">
			<div class="col-lg-12 col-md-12" style="padding-left: 0; padding-right: 0;">
				<h2 class="page-header">Announcements</h2>
				<?php if ($is_owner): ?>
					<div class="pull-right">
						<a href="../../editannouncement.php?course_alias=<?php echo $course_data['course_alias']; ?>" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-flash"></span>Create new</a>
					</div>
				<?php endif ?>
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
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main-content">
			<div class="row announcement">
				<div class="col-lg-12 col-md-12" style="padding-left: 0; padding-right: 0;">
					<h2 class="page-header">Video Lectures</h2>
					<?php if ($is_owner): ?>
					<div class="pull-right">
						<a href="#" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-flash"></span>Create new</a>
					</div>
					<?php endif ?>
				</div>
							<!-- Announcement holder-->
				<div class="col-lg-12 col-md-12" >
					<!-- Video dialog-->
					<div class="modal fade" id="vid-modal">
					  <div class="modal-dialog">
					    <div class="modal-content">
					      <div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					        <div class="modal-title">
					        		<h4 id="modal-title">Modal title</h4>
					        </div>
					      </div>
					      <div class="modal-body">
					        <div class="modal-video">
					        		<iframe src="" id="video-frame" sandbox="allow-same-origin allow-scripts allow-forms"></iframe>
					        </div>
					      </div>
					    </div><!-- /.modal-content -->
					  </div><!-- /.modal-dialog -->
					</div><!-- /.modal -->
					<!-- End video dialog-->
					<div class="panel-group" id="accordion"> 
					<?php 
					$v_units = $courses->get_distinct_unit($id);
					foreach ($v_units as $v_unit) { ?>
							<div class="panel panel-info">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" href="#collpase<?php echo $v_unit['unit_id'];?>"><?php echo $v_unit['unit_name']; ?></a>
									</h4>
								</div> <!-- End of .panel-heading-->
								<div id="collpase<?php echo $v_unit['unit_id'];?>" class="panel-collapse collapse in">
									<div class="panel-body">
										 <?php $v_vids = $courses->get_unit_video($id, $v_unit['unit_id']); ?>
										 <?php foreach ($v_vids as $v_vid): ?>
										 	<div class="show-vid-modal-wrapper">
											 	<a class="show-vid-modal" videosrc="<?php echo str_replace('watch?v=','embed/', $v_vid['vid_link']); ?>" videotitle="<?php echo $v_vid['vid_title']; ?>" href="#"><?php echo $v_vid['vid_title'] ?></a>
											 	<a href="#" class="pull-right slide"><span class="glyphicon glyphicon-list-alt"></span>Slides</a>
											 	<br>
										 	</div>
									 <?php endforeach ?>
									</div> <!-- End of .panel-body -->
								</div> <!-- End of .panel-collapse -->
							</div> <!-- End of .panel-default-->
					<?php }?>
					</div> <!-- End of #accordion-->
				</div>
			</div>
		</div>
		<?php endif ?>		
		<!-- End lecture.php-->

		<!-- For exercise.php -->
		<?php if ($filename == 'exercise.php'): ?>
			<?php if (!$is_registered): ?>
				<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main-content">
				<div class="row announcement">
					<div class="col-lg-12 col-md-12" style="padding-left: 0; padding-right: 0;">
						<h2 class="page-header">Exercises</h2>
						<?php if ($is_owner): ?>
							<!-- <div class="pull-right">
								<a href="../../newexercise.php?course=<?php echo $alias;?>" target="_blank" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-flash"></span>Creat new</a>
							</div> -->
						<?php endif ?>
					</div>

					<?php if (!$is_owner): ?>
						<div class="col-lg-12 col-md-12" style="padding-left: 0px;">
							<div class="alert alert-danger">
								<span>You need to <a href="../register.php?user_id=<?php echo $user_id ?>&amp;course=<?php echo $course_data['course_alias']; ?>">register</a> for this course in order to do exercises!</span>
							</div>
						</div>
					<?php else: ?>
						<div class="col-lg-12 col-md-12" style="padding-left: 0px;">
						<div class="row" style="margin-left: 0; padding-top:0;">
							<?php $v_units = $courses->get_distinct_unit($id); ?>
						<label style="margin-right: 15px;">Lecture </label>
						<select class="selectpicker" data-width="420px" id="unit-select">
							<?php foreach ($v_units as $v_unit): ?>
								<option unit-id="<?php echo $v_unit['unit_id']; ?>" value="<?php echo $v_unit['unit_id']; ?>">L<?php echo $v_unit['unit_id'] . ' - ' . $v_unit['unit_name']; ?></option>
							<?php endforeach ?>
						</select>
						<div class="pull-right">
							
							<?php if ($is_owner): ?>
								<button class="btn btn-danger" type="button" id="show_student_submit"><span class="glyphicon glyphicon-star"></span>Show student's submit</button>	
 							<?php else: ?>
								<a href="progress.php" class="btn btn-default" id="show_score"><span class="glyphicon glyphicon-star"></span>Show my achieved score</a>
							<?php endif ?>
						</div>
						</div>
						
						<div class="pagination-wrapper">
							<ul class="pagination" id="exercise_pagination">
							</ul>
						</div>
						<div class="row">
							<div class="col-md-12 col-xs-12 col-lg-12">
								<!-- Show a list of exercise here-->
								<?php $exercises = $courses->get_all_exercises($id);
								#foreach ($exercises as $exercise) { ?>
									<div class="panel panel-default" id="exercise_content_wrapper">
										<div class="panel-heading">
											<h4 class="panel-title" id="exercise_title"></h4>
										</div>
										<div class="panel-body" id="exercise_content" exercise_id="" question_type="">
											<div class="alert alert-info">Please choose a lecture to see its exercises.</div>
										</div>
										<?php if ($exercises[0]['question_type'] == '1'): ?>
										<div class="panel-footer" id="exercise_answer">
										
										</div>
										<?php endif ?>
									</div>
								
							</div>
						</div>

						<div class="row"  style="text-align: center; margin-bottom: 15px;">
							<button style="margin: auto;" id="submit_answer" type="submit" class="btn btn-success" name="submit_answer">Submit your answers</button>
							<button style="margin: auto;" id="save_answer" type="submit" class="btn btn-default" name="save_answer">Save your answers</button>
						</div>
					</div>
					<?php endif ?>
					
				</div>
			</div>  <!-- End of .main-content -->
		
			<?php else: ?>
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main-content">
				<div class="row announcement">
					<div class="col-lg-12 col-md-12" style="padding-left: 0; padding-right: 0;">
						<h2 class="page-header">Exercises</h2>
						<?php if ($is_owner): ?>
							<!-- <div class="pull-right">
								<a href="../../newexercise.php?course=<?php echo $alias;?>" target="_blank" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-flash"></span>Creat new</a>
							</div> -->
						<?php endif ?>
					</div>

					<div class="col-lg-12 col-md-12" style="padding-left: 0px;">
						<div class="row" style="margin-left: 0; padding-top:0;">
							<?php $v_units = $courses->get_distinct_unit($id); ?>
						<label style="margin-right: 15px;">Lecture </label>
						<select class="selectpicker" data-width="420px" id="unit-select">
							<?php foreach ($v_units as $v_unit): ?>
								<option unit-id="<?php echo $v_unit['unit_id']; ?>" value="<?php echo $v_unit['unit_id']; ?>">L<?php echo $v_unit['unit_id'] . ' - ' . $v_unit['unit_name']; ?></option>
							<?php endforeach ?>
						</select>
						<div class="pull-right">
							
							<?php if ($is_owner): ?>
								<button class="btn btn-danger" type="button" id="show_student_submit"><span class="glyphicon glyphicon-star"></span>Show student's submit</button>	
 							<?php else: ?>
								<a href="process.php" class="btn btn-default" id="show_score"><span class="glyphicon glyphicon-star"></span>Show my achieved score</a>
							<?php endif ?>
						</div>
						</div>
						
						<div class="pagination-wrapper">
							<ul class="pagination" id="exercise_pagination">
							</ul>
						</div>
						<div class="row">
							<div class="col-md-12 col-xs-12 col-lg-12">
								<!-- Show a list of exercise here-->
								<?php $exercises = $courses->get_all_exercises($id);
								#foreach ($exercises as $exercise) { ?>
									<div class="panel panel-default" id="exercise_content_wrapper">
										<div class="panel-heading">
											<h4 class="panel-title" id="exercise_title"></h4>
										</div>
										<div class="panel-body" id="exercise_content" exercise_id="" question_type="">
											<div class="alert alert-info">Please choose a lecture to see its exercises.</div>
										</div>
										<?php if ($exercises[0]['question_type'] == '1'): ?>
										<div class="panel-footer" id="exercise_answer">
										
										</div>
										<?php endif ?>
									</div>
								
							</div>
						</div>

						<div class="row"  style="text-align: center; margin-bottom: 15px;">
							<button style="margin: auto;" id="submit_answer" type="submit" class="btn btn-success" name="submit_answer">Submit your answers</button>
							<button style="margin: auto;" id="save_answer" type="submit" class="btn btn-default" name="save_answer">Save your answers</button>
						</div>
					</div>
				</div>
			</div>  <!-- End of .main-content -->
		<?php endif ?>
		<?php endif ?>

		<?php if ($filename == 'studentsubmit.php'): ?>
			<?php if (!$is_registered): ?>
				<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main-content">
				<div class="row announcement">
					<div class="col-lg-12 col-md-12" style="padding-left: 0; padding-right: 0;">
						<h2 class="page-header">Student submits</h2>
					</div>

					<?php if (!$is_owner): ?>
						<div class="col-lg-12 col-md-12" style="padding-left: 0px;">
							<div class="alert alert-danger">
								<span>You need to <a href="../register.php?user_id=<?php echo $user_id ?>&amp;course_alias=<?php echo $course_data['course_alias']; ?>">register</a> for this course in order to do exercises!</span>
							</div>
						</div>
					<?php else: ?>
						<div class="col-lg-12 col-md-12" style="padding-left: 0px;">
						<div class="row" style="margin-left: 0; padding-top:0;">
							<?php $v_units = $courses->get_distinct_unit($id); ?>
							<label style="margin-right: 15px;">Lecture </label>
							<select class="selectpicker" data-width="420px" id="unit-select">
								<?php foreach ($v_units as $v_unit): ?>
									<option unit-id="<?php echo $v_unit['unit_id']; ?>" value="<?php echo $v_unit['unit_id']; ?>">L<?php echo $v_unit['unit_id'] . ' - ' . $v_unit['unit_name']; ?></option>
								<?php endforeach ?>
							</select>
							<div class="pull-right">
								<label style="margin-right: 15px;">Student</label>
								<?php $v_enrollers = $courses->get_enroller($id); ?>
								<select class="selectpicker" data-width="320px" id="student_select">
									<?php foreach ($v_enrollers as $v_enroller): ?>
										<option value="<?php echo $v_enroller['user_id']; ?>"><span><?php echo $v_enroller['username']; ?></span> - <?php echo $v_enroller['display_name']; ?></option>
									<?php endforeach ?>
								</select>
							</div>
						<div class="pull-right">
						</div>
						</div>
						
						<div class="pagination-wrapper">
							<ul class="pagination" id="exercise_pagination">
							</ul>
						</div>
						<div class="row">
							<div class="col-md-12 col-xs-12 col-lg-12">
								<!-- Show a list of exercise here-->
								<?php $exercises = $courses->get_all_exercises($id);
								#foreach ($exercises as $exercise) { ?>
									<div class="panel panel-default" id="exercise_content_wrapper">
										<div class="panel-heading">
											<h4 class="panel-title" id="exercise_title"></h4>
										</div>
										<div class="panel-body" id="exercise_content" exercise_id="" question_type="">
											<div class="alert alert-info">Please choose a lecture to see its exercises.</div>
										</div>
										<?php if ($exercises[0]['question_type'] == '1'): ?>
										<div class="panel-footer" id="exercise_answer">
											
										</div>
										<?php endif ?>
									</div>
								
							</div>
						</div>

						<div class="row"  style="text-align: center; margin-bottom: 15px;">
							<button style="margin: auto;" id="submit_answer" type="submit" class="btn btn-success" name="submit_answer">Submit your answers</button>
							<button style="margin: auto;" id="save_answer" type="submit" class="btn btn-default" name="save_answer">Save your answers</button>
						</div>
					</div>
					<?php endif ?>
					
				</div>
			</div>  <!-- End of .main-content -->
		
			<?php else: ?>
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main-content">
			
			</div>  <!-- End of .main-content -->
		<?php endif ?>
		<?php endif ?>
		<!-- End studentsubmit.php -->

		<?php if ($filename == 'studentlist.php'): ?>
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main-content">
			<div class="modal fade" id="sendMessage" tabindex="-1" role="dialog" aria-labelledby="sendMessageLabel" aria-hidden="true">
	            <div class="modal-dialog">
	                <div class="panel panel-primary">
	                    <div class="panel-heading">
	                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	                        <h4 class="panel-title" id="sendMessageLabel"><span class="glyphicon glyphicon-envelope"></span>Send new message</h4>
	                    </div>
	                    <form action="#" method="post" accept-charset="utf-8">
	                    <div class="modal-body" style="padding: 5px;" id="messageModalBody">
	                           <div class="row">
	                                <div class="col-lg-12 col-md-12 col-sm-12" style="padding-bottom: 10px;">
	                                    <input class="form-control" id="messageSubject" name="subject" placeholder="Subject" type="text" required />
	                                </div>
	                            </div>
	                            <div class="row">
	                                <div class="col-lg-12 col-md-12 col-sm-12">
	                                    <textarea style="resize:vertical;" id="messageMsg" class="form-control" placeholder="Message..." rows="8" name="comment" required></textarea>
	                                </div>
	                            </div>
	                        </div>  
	                        <div class="panel-footer" style="margin-bottom:-14px;">
	                            <input type="button" class="btn btn-success" id="sendBtn"value="Send"/>
	                                <!--<span class="glyphicon glyphicon-ok"></span>-->
	                            <input type="reset" class="btn btn-danger" id="clearBtn" value="Clear" />
	                                <!--<span class="glyphicon glyphicon-remove"></span>-->
	                            <button style="float: right;" type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
	                        </div>
	                    </div>
	                </div>
	            </div>

				<div class="row" id="student-list" style="padding-left: 15px; padding-right: 15px;">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<h3 class="panel-title"><span class="glyphicon glyphicon-list"></span>Student list</h3>
								</div>
								<?php $enrollers = $courses->get_enroller($id); ?>
								<div class="panel-body">
									<table class="table">
										<thead>
											<tr>
												<th>No.</th>
												<th>Firstname</th>
												<th>Lastname</th>
												<th>Username</th>
												<th>Register date</th>
												<th>Send message</th>
											</tr>
										</thead>
										<tbody>
										<?php $no = 0; ?>
										<?php foreach ($enrollers as $enroller): ?>
											
											<tr>
												<th><?php echo ++$no; ?></th>
												<th><?php echo $enroller['first_name'];?></th>
												<th><?php echo $enroller['last_name'];?></th>
												<th><a href="../../profile.php?username=<?php echo $enroller['username']; ?>"><?php echo $enroller['username'];?></a></th>
												<th><?php echo date('d-M-Y', $enroller['time']); ?></th>
												<th>
													<a href="#" class="btn btn-default btn-sm" name="send_mes_btn" sender_id="<?php echo $user_id; ?>" sender="<?php echo $users->fetch_info('username', 'user_id', $user_id); ?>" receiver_id="<?php echo $enroller['user_id'];?>" receiver="<?php echo $enroller['username']; ?>"><span class="glyphicon glyphicon-pencil"></span>Send message</a>
												</th>
											</tr>
										<?php endforeach ?>
											
										</tbody>
									</table>
								</div>
							</div>
				</div>
				</div>
			</div>
		<?php endif ?>
	</div>
</div>
<!-- End .main content -->
<!-- Javascript-->
<script type="text/javascript">
 $(document).ready(function(e) {
     $('.selectpicker').selectpicker();
 });
</script>
<?php if ($filename == 'lecture.php'): ?>
	<script>
	$('a.show-vid-modal').click(function(e) { 
	 var vidsrc = $(this).attr('videosrc');
     var title = $(this).attr('videotitle');

	 e.preventDefault();

	 var options = {
	   "backdrop" : "static"
	 }

	$("#vid-modal").on('shown.bs.modal', function(e) {
	    //here the attribute video-src is helpfull
	     $("h4#modal-title").text(title);
	    // //here the id for the iframe is helpfull
	     $('#video-frame').attr('src', vidsrc);
	  });

	$("#vid-modal").on('hide.bs.modal', function(e) {
	    // //here the id for the iframe is helpfull
	     $('#video-frame').attr('src', '');
	  });

    $("#vid-modal").modal(options);
});
</script>
<?php endif ?>

<?php if ($filename == 'exercise.php'): ?>
	<script type="text/javascript">
	$('.pagination-wrapper').hide();
	/* pagination */
	$('#unit-select').change(function() {
		var unit_id = $(this).val();
		var type = 'unitexercise';
		var url = '../../processor/fetch.php';
		var course_alias = '<?php echo $alias ?>';

		$.ajax({
			type 		: 'POST',
			url 		: url,
			data 		: {
				type  : type,
				unit_id : unit_id,
				course_alias : course_alias
			},
			dataType : 'json',
			success  : function(data) {
				var nPage = data.length;

				var score = '<label class="pull-right label label-info">Score: '

				if (nPage > 1) {
					var paginate_str = '';
					var answer_html = '<strong>What is your answer?</strong><br>';
					
					$('#exercise_title').html(data[0].exercise_title + score + data[0].score + '</label>');
					$('#exercise_content').attr('exercise_id', 1);
					$('#exercise_content').html(data[0].question);
					$('#exercise_content').attr('question_type', data[0].question_type);
					if (data[0].question_type == 1) {
						answer_html = '<strong>What is your answer?</strong><br><input class="exercise_choice_radio" type="radio" name="exercise_choice" value="A"><span class="exercise_multiple">' + data[0].multi_one+'</span><br>'
						             + '<input class="exercise_choice_radio" type="radio" name="exercise_choice" value="B"><span class="exercise_multiple">' + data[0].multi_two+'</span><br>'
						             + '<input class="exercise_choice_radio" type="radio" name="exercise_choice" value="C"><span class="exercise_multiple">' + data[0].multi_three+'</span><br>' 
						             + '<input class="exercise_choice_radio" type="radio" name="exercise_choice" value="D"><span class="exercise_multiple">' + data[0].multi_four+'</span><br>';
						$('#exercise_answer').html(answer_html);
					} else {
						answer_html = '<strong>What is your answer?</strong><br><textarea class="exercise_answer_text form-control" ex_id="'+1+'" placeholer="Enter your answer here"></textarea>';
						$('#exercise_answer').html(answer_html);
					}
					
					
					for (i = 1; i <= nPage; i++) {
						var ex_id = data[i-1].exercise_id;

						paginate_str += '<li class="paginate_li"><a class="paginate_item" href="#" ex_id="' + ex_id + '">' + i + '</a></li>';
						$('#exercise_pagination').html(paginate_str);
						$('.paginate_item').each(function() {

							/* Actions happened when user click the pagination number */
							$('.paginate_item').click(function(e) {
								e.preventDefault();
								var exercise_id = $(this).attr('ex_id');
								// $('.paginate_li').addClass('active');
								// Remove active class from other
								// for (j = 1; j <= nPage; j++) {

								// }

								$('#exercise_title').html(data[exercise_id-1].exercise_title + score + data[exercise_id-1].score + '</label>');
								$('#exercise_content').attr('exercise_id', exercise_id);
								$('#exercise_content').html(data[exercise_id-1].question);
								$('#exercise_content').attr('question_type', data[exercise_id-1].question_type);

								if (data[exercise_id-1].question_type == 1) {
									answer_html = '<strong>What is your answer?</strong><br><input class="exercise_choice_radio" type="radio" name="exercise_choice" value="A"><span class="exercise_multiple">' + data[exercise_id-1].multi_one+'</span><br>'
									             + '<input class="exercise_choice_radio" type="radio" name="exercise_choice" value="B"><span class="exercise_multiple">' + data[exercise_id-1].multi_two+'</span><br>'
									             + '<input class="exercise_choice_radio" type="radio" name="exercise_choice" value="C"><span class="exercise_multiple">' + data[exercise_id-1].multi_three+'</span><br>' 
									             + '<input class="exercise_choice_radio" type="radio" name="exercise_choice" value="D"><span class="exercise_multiple">' + data[exercise_id-1].multi_four+'</span><br>';
									$('#exercise_answer').html(answer_html);
								} else {
									answer_html = '<strong>What is your answer?</strong><br><textarea class="exercise_answer_text form-control" ex_id="'+exercise_id+'" placeholer="Enter your answer here"></textarea>';
									$('#exercise_answer').html(answer_html);
								}
							});
						});
					}
					$('.pagination-wrapper').show();
				} else if (nPage < 1) {
					var html_str = '<span>There is no exercise within this lecture</span>'
					$('#exercise_content').html(html_str);	
					$('.pagination-wrapper').hide();
					$('#exercise_answer').text('');
					$('#exercise_title').html('');			
				} else if (nPage == 1) {
					$('#exercise_title').html(data[0].exercise_title + score + data[0].score + '</label>');
					$('.pagination-wrapper').hide();
					$('#exercise_content').attr('exercise_id', 1);
					$('#exercise_content').html(data[0].question);
					$('#exercise_content').attr('question_type', data[0].question_type);

					if (data[0].question_type == 1) {
						answer_html = '<strong>What is your answer?</strong><br><input class="exercise_choice_radio" type="radio" name="exercise_choice" value="A"><span class="exercise_multiple">' + data[0].multi_one+'</span><br>'
						             + '<input class="exercise_choice_radio" type="radio" name="exercise_choice" value="B"><span class="exercise_multiple" value="B">' + data[0].multi_two+'</span><br>'
						             + '<input class="exercise_choice_radio" type="radio" name="exercise_choice" value="C"><span class="exercise_multiple" value="C">' + data[0].multi_three+'</span><br>' 
						             + '<input class="exercise_choice_radio" type="radio" name="exercise_choice" value="D"><span class="exercise_multiple" value="D">' + data[0].multi_four+'</span><br>';
						$('#exercise_answer').html(answer_html);
					} else {
						answer_html = '<strong>What is your answer?</strong><br><textarea class="exercise_answer_text form-control" ex_id="'+1+'" placeholer="Enter your answer here"></textarea>';
						$('#exercise_answer').html(answer_html);
					}
				}
				
			}
		});
	});
</script>
<script type="text/javascript">
	$('#submit_answer').click(function(e) {
		e.preventDefault();

		var user_id       = '<?php echo $user_id; ?>';
		var course_id     = '<?php echo $course_id; ?>';
		var unit_id       = $('#unit-select').val();
		var exercise_id   = $('#exercise_content').attr('exercise_id');
		var question_type = $('#exercise_content').attr('question_type');

		var answer = '';

		/* Written exercises */
		if (question_type == 2) {
			answer = $('#exercise_answer textarea').val();
		} else if (question_type == 1) {
			var checked_exercise_choice = $('input:radio[name=exercise_choice]:checked').val();
			if (checked_exercise_choice != undefined) {
				answer = checked_exercise_choice;
			};
		}
	
		var request_data = {
			"type"			 : 'exercise_attempt',
			"user_id"	    : user_id,
			"course_id"     : course_id,
			"unit_id"       : unit_id,
			"exercise_id"   : exercise_id,
			"question_type" : question_type,
			"answer"        : answer,
			"status"			 : 0
		};

		var url = '../../processor/create.php';

		$.ajax({
			type : 'POST',
			url  : url,
			data : request_data,
			// contentType: "application/json; charset=utf-8",
			// dataType: "json",
			success : function(data) {
				if (data == 2) {
					alert('Your answer has been submitted and pending for teacher\'s feedback');
				} else if (data == 3) {
					alert('Your answer is correct');
				} else if (data == 4) {
					alert('Your answer is incorrect');
				}
			}
		});
	});
</script>
<script>
		$('#save_answer').click(function(e) {
			e.preventDefault();

		var user_id       = '<?php echo $user_id; ?>';
		var course_id     = '<?php echo $course_id; ?>';
		var unit_id       = $('#unit-select').val();
		var exercise_id   = $('#exercise_content').attr('exercise_id');
		var question_type = $('#exercise_content').attr('question_type');

		var answer = '';

		/* Written exercises */
		if (question_type == 2) {
			answer = $('#exercise_answer textarea').val();
		} else if (question_type == 1) {
			var checked_exercise_choice = $('input:radio[name=exercise_choice]:checked').val();
			if (checked_exercise_choice != undefined) {
				answer = checked_exercise_choice;
			};
		}
	
		var request_data = {
			"type"			 : 'exercise_save',
			"user_id"	    : user_id,
			"course_id"     : course_id,
			"unit_id"       : unit_id,
			"exercise_id"   : exercise_id,
			"question_type" : question_type,
			"answer"        : answer,
			"status"			 : 1
		};

		var url = '../../processor/create.php';
		$.ajax({
			type : 'POST',
			url  : url,
			data : request_data,
			success : function(data) {
				if (data == 1) {
					alert('Your answer has been saved');
				}
			}
		});		
		});
</script>
<?php endif ?>

<?php if ($filename == 'studentsubmit.php'): ?>
	<script type="text/javascript">
	$('#student_select').change(function(e) {

	});
	</script>
	<script type="text/javascript">
		$('#unit-select').change(function(e) {
			var unit_id = $(this).val();
			var user_id = $('#student_select').val();
			var course_id = <?php echo $id; ?>;
			var type = 'studentsubmit';

			$.ajax({
				type : 'POST',
				url  : '../../processor/fetch.php',
				data {
					type : type,
					unit_id : unit_id,
					course_id : course_id,
					user_id : user_id
				},
				success : function(data) {
					console.log(data);
				}
			});
		});
	</script>
<?php endif ?>

<?php if ($filename == 'studentlist.php'): ?>
	<script type="text/javascript">
	$('a[name="send_mes_btn"]').click(function(e) {
		var sender_id = $(this).attr('sender_id');
		var receiver_id = $(this).attr('receiver_id');
		var receiver = $(this).attr('receiver');

		var options = {
			"backdrop" : "static"
		}
		$('#sendMessageLabel').text('Send message to ' + receiver);
		$('#sendMessage').modal(options);

		$('#sendBtn').click(function(e) {
			e.preventDefault();
			$('.alert-success').remove();
			$('.alert-danger').remove();

			var subject = $('#messageSubject').val();
			var message = $('#messageMsg').val();

			$.ajax({
				type : 'POST',
				url  : '../../processor/create.php',
				data : {
					type 	: 'sendmessage',
					sender_id : sender_id,
					receiver_id : receiver_id,
					subject : subject,
					message : message
				},
				success : function(e) {
					$('#messageModalBody').append('<div class="alert alert-success">Your message has been sent</div>');
				},
				error : function(e) {
					$('#messageModalBody').append('<div class="alert alert-danger">There is something wrong, please try again</div>');
				}
			});
		});
	})
	</script>
<?php endif ?>
</body>
</html>
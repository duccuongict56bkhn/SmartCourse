<?php 
require 'core/init.php';
require 'navbar.php';
$general->logged_out_protect();
?>

<?php if (isset($_GET['course_alias']) && !empty($_GET['course_alias'])) { 
	$alias = htmlentities($_GET['course_alias']);
	if (!$courses->course_exists($alias)) {
		header('Location: index.php');
		die();
	} else if (!$courses->is_created_by_me($user_id, $courses->get_ifa($alias))) {
		header('Location: index.php');
		die();
	} else {
		$course_data = array();
		$id 		    = $courses->get_ifa($alias);
		$course_data = $courses->coursedata($id);
	}
?>
<div class="container-fluid admin-panel">
	<div class="row">
		<div class="col-sm-3 col-md-2 sidebar">
			<ul class="nav nav-sidebar">
				<li><a href="editcourse.php?course_alias=<?php echo $course_data['course_alias']; ?>" ><span class="glyphicon glyphicon-home"></span>Dashboard</a></li>
				<li><a href="#announcement"><span class="glyphicon glyphicon-bullhorn"></span>Announcements</a></li>
				<li><a href=""><span class="glyphicon glyphicon-picture"></span>Photos</a></li>
				<li><a href="#"><span class="glyphicon glyphicon-eye-open"></span>Syllabus</a></li>
				<li><a href="#"><span class="glyphicon glyphicon-calendar"></span>Calendar</a></li>
				<li><a href="#"><span class="glyphicon glyphicon-book"></span>Lectures</a></li>
				<li><a href="editexercise.php?course_alias=<?php echo $course_data['course_alias']; ?>" class="active"><span class="glyphicon glyphicon-tasks"></span>Exercises</a></li>
				<li><a href="#"><span class="glyphicon glyphicon-print"></span>Course materials</a></li>
				<li><a href="#"><span class="glyphicon glyphicon-bookmark"></span>Discussions</a></li>
			</ul>
		</div> <!-- end of .sidebar -->

		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">Course Exercises</h1>
				<div class="page-segment" id="dashboard">
					<ol class="breadcrumb">
						<li><a href="editcourse.php?course_alias=<?php echo $course_data['course_alias']; ?>"><span class="glyphicon glyphicon-home"></span>Dashboard</a></li>
						<li><span class="glyphicon glyphicon-tasks"></span>Course exercises</li>
					</ol>
					<div class="row" id="statistic">
						<div class="col-md-4">
							<select class="selectpicker" name="ex_filter">
								<option value="0">All</option>
								<?php $v_units = $courses->get_distinct_unit($id) ?>
								<?php foreach ($v_units as $v_unit): ?>
									<option>L<?php echo $v_unit['unit_id'] . ' - ' . $v_unit['unit_name']; ?></option>
								<?php endforeach ?>
							</select>
						</div>
						<div class="col-md-6">
							<button class="btn btn-default">Create new</button>
						</div>
					</div>
				</div>
		</div>
	</div>
</div> <!-- end of .container -->

<?php } else { 
	header('Location: courses.php');}
	?>
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
				<li><a href="editannouncement.php?course_alias=<?php echo $course_data['course_alias'];?>" ><span class="glyphicon glyphicon-bullhorn"></span>Announcements</a></li>
				<li><a href="editphoto.php?course_alias=<?php echo $course_data['course_alias'];?>"><span class="glyphicon glyphicon-picture"></span>Photos</a></li>
				<li><a href="editsyllabus.php?course_alias=<?php echo $course_data['course_alias'];?>"><span class="glyphicon glyphicon-eye-open"></span>Syllabus</a></li>
				<li><a href="editlecture.php?course_alias=<?php echo $course_data['course_alias'];?>"><span class="glyphicon glyphicon-book"></span>Lectures</a></li>
				<li><a href="editexercise.php?course_alias=<?php echo $alias; ?>" class="active"><span class="glyphicon glyphicon-tasks"></span>Exercises</a></li>
				<!-- <li><a href="editmaterial.php?course_alias=<?php echo $alias; ?>"><span class="glyphicon glyphicon-print"></span>Course materials</a></li>
				<li><a href="courseforum.php?course_alias=<?php echo $alias; ?>"><span class="glyphicon glyphicon-bookmark"></span>Discussions</a></li> -->
			</ul>
		</div> <!-- end of .sidebar -->

		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">Course Exercises</h1>
				<div class="page-segment" id="dashboard">
					<ol class="breadcrumb">
						<li><a href="editcourse.php?course_alias=<?php echo $course_data['course_alias']; ?>"><span class="glyphicon glyphicon-home"></span>Dashboard</a></li>
						<li><span class="glyphicon glyphicon-tasks"></span>Course exercises</li>
					</ol>
					<div class="row announcement" id="statistic">
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
							<a href="newexercise.php?mode=create&amp;course=<?php echo $alias;?>" target="_blank" class="btn btn-default">Create new</a>
						</div>
					</div>

					<?php $b_exs = $courses->get_all_exercises($course_data['course_id']); ?>
					<?php foreach ($b_exs as $b_ex): ?>
						<div class="row" style="margin-left: 0px; margin-right:0px;" id="exercise" exercise_id="<?php echo $b_ex['exercise_id']; ?>" unit_id="<?php echo $b_ex['unit_id']; ?>">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><?php echo $b_ex['exercise_title'] ?>
										<label class="pull-right label label-default" name="deleteBtn" exercise_id="<?php echo $b_ex['exercise_id']; ?>" unit_id="<?php echo $b_ex['unit_id']; ?>"><a href="#" style="color: white;"><span class="glyphicon glyphicon-trash"></span>Delete</a></label>  
										<label style="margin-right: 10px;"class="pull-right label label-default" name="editBtn" exercise_id="<?php echo $b_ex['exercise_id']; ?>" unit_id="<?php echo $b_ex['unit_id']; ?>"><a href="#" style="color: white;"><span class="glyphicon glyphicon-pencil"></span>Edit</a></label>
										
									</h4>
								</div>
								<div class="panel-body">
									<div class="question">
										<?php echo $b_ex['question']; ?>
									</div>
								</div>
								<div class="panel-footer">
									<?php if ($b_ex['question_type'] == 1): ?>
										<span><label class="label label-success" style="margin-right: 10px;">A</label> <?php echo $b_ex['multi_one']; ?></span><br>
										<span><label class="label label-success" style="margin-right: 10px;">B</label><?php echo $b_ex['multi_two']; ?></span><br>
										<span><label class="label label-success" style="margin-right: 10px;">C</label> <?php echo $b_ex['multi_three']; ?></span><br>
										<span><label class="label label-success" style="margin-right: 10px;">D</label> <?php echo $b_ex['multi_four']; ?></span><br>
									<?php else: ?>
										<span>Written exercise</span>
									<?php endif ?>
								</div>
							</div>
						</div>
					<?php endforeach ?>
				</div>
		</div>
	</div>
</div> <!-- end of .container -->
<script type="text/javascript">
	$('.question').readmore();
</script>
<?php } else { 
	header('Location: courses.php');}
	?>
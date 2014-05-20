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
				<li><a href="editlecture.php?course_alias=<?php echo $course_data['course_alias'];?>" class="active"><span class="glyphicon glyphicon-book"></span>Lectures</a></li>
				<li><a href="editexercise.php?course_alias=<?php echo $alias; ?>"><span class="glyphicon glyphicon-tasks"></span>Exercises</a></li>
				<!-- <li><a href="editmaterial.php?course_alias=<?php echo $alias; ?>"><span class="glyphicon glyphicon-print"></span>Course materials</a></li>
				<li><a href="courseforum.php?course_alias=<?php echo $alias; ?>"><span class="glyphicon glyphicon-bookmark"></span>Discussions</a></li> -->
			</ul>
		</div> <!-- end of .sidebar -->

		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header">Course Lectures</h1>
				<div class="page-segment" id="dashboard">
					<ol class="breadcrumb">
						<li><a href="courses/<?php echo $course_data['course_alias'] . '/'; ?>"><span class="glyphicon glyphicon-bookmark"></span><?php echo $course_data['course_title']; ?></a></li>
						<li><a href="editcourse.php?course_alias=<?php echo $course_data['course_alias']; ?>"><span class="glyphicon glyphicon-home"></span>Dashboard</a></li>
						<li><span class="glyphicon glyphicon-book"></span>Course lecures</li>
					</ol>
					
					<div class="row">
						<div class="col-xs-4 col-md-3" id="lecture-list-group">
							<div class="list-group">
								<?php 
								$id = $courses->get_ifa($alias);
								$v_units = $courses->get_distinct_unit($id);
								foreach ($v_units as $v_unit) { ?>
									<?php if ($v_unit['unit_id'] == 1): ?>
									 	<a href="#" class="list-group-item unit-group-item active" id="u<?php echo $v_unit['unit_id'];?>" course-id="<?php echo $id; ?>"><?php echo $v_unit['unit_name']; ?></a>
								   <?php else: ?>
									   <a href="#" class="list-group-item unit-group-item" id="u<?php echo $v_unit['unit_id'];?>" course-id="<?php echo $id; ?>"><?php echo $v_unit['unit_name']; ?></a>
									<?php endif;?>
								 <?php } ?>
							</div>
						</div>
						<div class="col-xs-8 col-md-9" id="lecture-edit-detail">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><span class="glyphicon glyphicon-list" style="color: #bbb;"></span>Details</h4>
								</div>
								<div class="panel-body" id="detail-panel-body">
									<div class="row" id="detail-panel-statistic">
										<!-- Show basic lecture statistic here -->
										<div class="col-md-6" style="border: 1px solid #bbb;">
											<span>text</span>
										</div>
										<div class="col-md-6" style="border: 1px solid #bbb;">
											<span>text</span>
										</div>
									</div> <!-- End of detail-panel-statistic-->
									<div class="row lecture-video-container">
										<iframe width="680" height="450" src="http://www.youtube.com/embed/D-k-h0GuFmE">
										</iframe>
										<form role="form" id="video-meta">
											<div class="form-group">
												<label>Lecture title</label>
												<input type="text" class="form-control" name="inputLectureTitle" id="inputLectureTitle" placeholder="Lecture title" value="">
											</div>
											<div class="form-group">
												<label>Video link</label>
												<input type="text" class="form-control" name="inputVideoLink" id="inputVideoLink" placeholder="Video link" value="">
											</div>
										</form>
									</div>
								</div>
							</div>				
						</div>
					</div>
				</div>
		</div>
	</div>
</div> <!-- end of .container -->
<script type="text/javascript">
	$('.unit-group-item').each(function(index) {
		$(this).click(function(e) {
			e.preventDefault();

			/* Load corresponding lecture data to detail panel */
			var unit_id = $(this).attr('id').replace('u','');
			var type = 'lecture';

			$.ajax({
				type 		: 'POST',
				url 		: 'processor/fetch.php',
				data 		: {
					type	: type,
					
				}
			});
		});
	});
</script>
<?php } else { 
	header('Location: courses.php');}
	?>
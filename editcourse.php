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
		$annos = $courses->get_announcement($course_data['course_id']);
	}

	if (isset($_POST['update']) && !empty($_POST['update'])) {
		if (isset($_FILES['avatar']) && !empty($_FILES['avatar']['name'])) {
			$name 			= $_FILES['avatar']['name'];	// get the file name
 			$tmp_name		= $_FILES['avatar']['tmp_name'];
 			$allowed_text	= array('jpg', 'jpeg', 'png', 'gif');
 			$a 				= explode('.', $name);
 			$file_ext		= strtolower(end($a)); unset($a);		// getting the allowed extensions
 			$path			= "images/courses/";			// the folder to store

 			$newpath = $general->file_newpath($path, $name);
 			move_uploaded_file($tmp_name, $newpath);

 			$course_desc = htmlentities(trim($_POST['course_desc']));
 			$avatar 	 = htmlentities(trim($newpath));

 			$rel = $courses->update_course($course_data['course_id'], $course_desc, $avatar);
 			var_dump($rel);
 			if ($rel === true) {
 				header('Location: editcourse.php?success');
	 			exit();
 			} else {
 				var_dump($rel);
 			}
		}
	}

	if (isset($_POST['create-anno'])) {
		$anno_id = rand(2, 10000);
		$anno_title = $_POST['anno-title'];
	   $anno_content = $_POST['anno-content'];
	   $create_date = time();
	   $anno_type =  $_POST['anno-type'];
	   $valid_from = new DateTime($_POST['anno-valid-from']);
	   $valid_to = new DateTime($_POST['anno-valid-to']);
	   try {
	   	$courses->create_announcement($user_id, $course_data['course_id'], $anno_id, $anno_title, $anno_content, $create_date, $anno_type, $valid_from, $valid_to);
	   } catch (PDOException $e) {
	   	die($e->getMesssage());
	   }
	   unset($_POST['create-anno']);
	}
?>
<div class="container-fluid admin-panel">
	<div class="row">
		<div class="col-sm-3 col-md-2 sidebar">
			<ul class="nav nav-sidebar">
				<li><a href="editcourse.php?course_alias=<?php echo $course_data['course_alias']; ?>" class="active"><span class="glyphicon glyphicon-home"></span>Dashboard</a></li>
				<li><a href="editannouncement.php?course_alias=<?php echo $course_data['course_alias'];?>" ><span class="glyphicon glyphicon-bullhorn"></span>Announcements</a></li>
				<li><a href="editphoto.php?course_alias=<?php echo $course_data['course_alias'];?>"><span class="glyphicon glyphicon-picture"></span>Photos</a></li>
				<li><a href="editsyllabus.php?course_alias=<?php echo $course_data['course_alias'];?>"><span class="glyphicon glyphicon-eye-open"></span>Syllabus</a></li>
				<li><a href="editlecture.php?course_alias=<?php echo $course_data['course_alias'];?>"><span class="glyphicon glyphicon-book"></span>Lectures</a></li>
				<li><a href="editexercise.php?course_alias=<?php echo $alias; ?>"><span class="glyphicon glyphicon-tasks"></span>Exercises</a></li>
				<li><a href="editmaterial.php?course_alias=<?php echo $alias; ?>"><span class="glyphicon glyphicon-print"></span>Course materials</a></li>
				<li><a href="courseforum.php?course_alias=<?php echo $alias; ?>"><span class="glyphicon glyphicon-bookmark"></span>Discussions</a></li>
			</ul>
		</div> <!-- end of .sidebar -->

		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header"><?php echo $course_data['course_title']; ?></h1>
				<div class="page-segment" id="dashboard">
					<ol class="breadcrumb">
						<li><a href="#"><span class="glyphicon glyphicon-home"></span>Dashboard</a></li>
					</ol>
					<div class="alert alert-info">
						<p>Welcome to <strong>Setting Panel</strong> for <?php echo $course_data['course_title']; ?>. Here you can view all contents, settings for your course. 
						Navigate to the left sidebar, you can customize, edit those settings and contents.</p>
					</div>
                    <div class="row">
                        <div class="panel-group" id="accordion">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Basic information</a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse in">
                                  <div class="panel-body">
                                      <div class="row info">
                                          <div class="col-md-4">
                                            <span>Title: 
                                            		<a href="#" class="editable-field" id="course_title" data-pk="<?php echo $id ?>" data-type="text" data-title="Enter course title">
	                                            		<strong><?php echo $course_data['course_title'];?></strong>
                                            		</a>
                                            </span><br>
                                            <span>Code: <strong><?php echo $course_data['course_code'];?></strong></span><br>
                                            <span>Alias: <strong id="course_alias"><?php echo $course_data['course_alias'];?></strong></span><br>
                                          </div>
                                          <div class="col-md-4">
                                            <span>Type: <strong><?php echo ($course_data['course_type'] == 1) ? 'Self-study' : 'Period';?></strong></span><br>
                                            <span>Start date: <strong><?php echo $course_data['start_date'];?></strong></span><br>  
                                            <span>Length: <a id="length" class="editable-field" data-pk="<?php echo $id;?>" data-type="text" data-title="Enter length of course"><strong><?php echo $course_data['length'];?></strong></a><strong> weeks</strong></span><br>
                                          </div>
                                           <div class="col-md-4">
                                            <?php $teacher = $courses->get_teacher($course_data['course_id']);?>
                                            <span>Teacher: <strong><?php echo $teacher['display_name'];?></strong></span><br>  
                                            <span>School: 
	                                            <a href="#" class="editable-field" id="school" data-pk="<?php echo $id ?>" data-type="text" data-title="School name">
	                                            	<strong><?php echo $course_data['school'];?></strong>
	                                            </a>
                                            </span>                                            
                                          </div>
                                      </div>
                                      <div class="row info">
                                        <span>Description:</span><br>
                                        <span href="#" class="editable-field" id="course_desc" data-pk="<?php echo $id ?>" data-type="textarea" data-title="Course description"><?php echo $course_data['course_desc'];?></span>
                                      
                                      </div>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="row" id="statistic">
						<div class="col-lg-3">
							<div class="panel panel-default panel-success">
								<div class="panel-heading panel-success">
									<div class="row">
										<div class="col-xs-6">
											<span class="glyphicon glyphicon-user"></span>
										</div>
										<div class="col-xs-6 text-right">
										<?php $enroll_num = $courses->get_num_enroller($id); ?>
											<p class="figure-heading"><?php echo $enroll_num; ?></p>
										</div>
										<div class="text-right" style="padding-right: 14px;"><p>Students are taking this course</p></div>
									</div>
								</div>
								<div class="panel-footer alert-success">
								<a href="#">View details</a>
								</div>
							</div>
						</div>
						<div class="col-lg-3">
							<div class="panel panel-default panel-info">
								<div class="panel-heading panel-info">
									<div class="row">
										<div class="col-xs-6">
											<span class="glyphicon glyphicon-tasks"></span>
										</div>
										<div class="col-xs-6 text-right">
											<?php $ex_num = $courses->get_num_exercise($id); ?>
											<p class="figure-heading"><?php echo $ex_num; ?></p>
										</div>
										<div class="text-right" style="padding-right: 14px;"><p>Exercises in this course</p></div>
									</div>
								</div>
								<div class="panel-footer panel-info">
								<a href="#">View details</a>
								</div>
							</div>
						</div>

						<div class="col-lg-3">
							<div class="panel panel-default panel-warning">
								<div class="panel-heading panel-warning">
									<div class="row">
										<div class="col-xs-6">
											<span class="glyphicon glyphicon-star"></span>
										</div>
										<div class="col-xs-6 text-right">
											<p class="figure-heading">4.5</p>
										</div>
										<div class="text-right" style="padding-right: 14px;"><p>is average vote for this course</p></div>
									</div>
								</div>
								<div class="panel-footer panel-warning">
								<a href="#">View details</a>
								</div>
							</div>
						</div>

						<div class="col-lg-3">
							<div class="panel panel-default panel-danger">
								<div class="panel-heading panel-danger">
									<div class="row">
										<div class="col-xs-6">
											<span class="glyphicon glyphicon-fire"></span>
										</div>
										<div class="col-xs-6 text-right">
											<p class="figure-heading">2</p>
										</div>
										<div class="text-right" style="padding-right: 14px;"><p>is the number of exams</p></div>
									</div>
								</div>
								<div class="panel-footer panel-danger">
								<a href="#">View details</a>
								</div>
							</div>
						</div>
					</div>
					<div class="row" id="student-list" style="padding-left: 15px; padding-right: 15px;">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h3 class="panel-title"><span class="glyphicon glyphicon-list"></span>Student list</h3>
							</div>
							<div class="panel-body">
								<table class="table">
									<thead>
										<tr>
											<th>No.</th>
											<th>Firstname</th>
											<th>Lastname</th>
											<th>Username</th>
											<th>Register date</th>
											<th>Current progress</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<th>1</th>
											<th>Cuong</th>
											<th>Dao Duc</th>
											<th>cuongdd</th>
											<th>28-Apr-2014</th>
											<th>
												<div class="progress">
													<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
    												60%
  													</div>
												</div>
											</th>
										</tr>
										<tr>
											<th>2</th>
											<th>Tien</th>
											<th>Le Anh</th>
											<th>tiendepzai</th>
											<th>29-Apr-2014</th>
											<th>
												<div class="progress">
													<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100" style="width: 5%;">
    												5%
  													</div>
												</div>
											</th>
										</tr>
										<tr>
											<th>3</th>
											<th>Tuan</th>
											<th>Hoang Minh</th>
											<th>tuanhm</th>
											<th>26-Apr-2014</th>
											<th>
												<div class="progress">
													<div class="progress-bar" role="progressbar" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100" style="width: 43%;">
    												43%
  													</div>
												</div>
											</th>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

				
		</div>
	</div>
</div> <!-- end of .container -->

<script type="text/javascript">
	$(document).ready(function() {
		$.fn.editable.defaults.mode = 'inline';
		var urlstr = 'processor/editprocess.php';
		// alert(urlstr);
		$('.editable-field').editable({
			url	 : urlstr,
			fail : function(data) {
				console.log(data);
			}	
		});
		// $("#accordion").click(function() {
		// 	alert(course_alias);
		// });
	});
</script>
<?php } else { 
	header('Location: courses.php');}?>
<?php 

 ?>
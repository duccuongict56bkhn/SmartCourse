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
				<li><a href="editcourse.php?course_alias=<?php echo $course_data['course_alias']; ?>" ><span class="glyphicon glyphicon-home"></span>Dashboard</a></li>
				<li><a href="editannouncement.php?course_alias=<?php echo $course_data['course_alias'];?>" ><span class="glyphicon glyphicon-bullhorn"></span>Announcements</a></li>
				<li><a href="editphoto.php?course_alias=<?php echo $course_data['course_alias'];?>" class="active"><span class="glyphicon glyphicon-picture"></span>Photos</a></li>
				<li><a href="editsyllabus.php?course_alias=<?php echo $course_data['course_alias'];?>"><span class="glyphicon glyphicon-eye-open"></span>Syllabus</a></li>
				<li><a href="editlecture.php?course_alias=<?php echo $course_data['course_alias'];?>"><span class="glyphicon glyphicon-book"></span>Lectures</a></li>
				<li><a href="editexercise.php?course_alias=<?php echo $alias; ?>" ><span class="glyphicon glyphicon-tasks"></span>Exercises</a></li>
				<!-- <li><a href="editmaterial.php?course_alias=<?php echo $alias; ?>"><span class="glyphicon glyphicon-print"></span>Course materials</a></li>
				<li><a href="courseforum.php?course_alias=<?php echo $alias; ?>"><span class="glyphicon glyphicon-bookmark"></span>Discussions</a></li> -->
			</ul>
		</div> <!-- end of .sidebar -->

		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header"><?php echo $course_data['course_title']; ?></h1>
				<div class="page-segment" id="dashboard">
					<ol class="breadcrumb">
						<li><a href="#"><span class="glyphicon glyphicon-home"></span>Dashboard</a></li>
						<li><span class="glyphicon glyphicon-picture"></span>Photos</li>
					</ol>
					<div class="alert alert-info">
						<p>Welcome to <strong>Setting Panel</strong> for <?php echo $course_data['course_title']; ?>. Here you can view all contents, settings for your course. 
						Navigate to the left sidebar, you can customize, edit those settings and contents.</p>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Course avatar</h4>
						</div>
						<div class="panel-body">
							<div class="fileupload fileinput-exists" data-provides="fileinput" id="avatarFileInput">
								<div style="margin-bottom: 5px;">
									<strong>Note: </strong><span>You should choose images in size proportional to ratio of 400px &times; 277px</span>
								</div>
							  <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 139px;" id="avatarPreview"></div>
							  <div>
							    <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="..."></span>
							    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
							  </div>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Course cover photo</h4>
						</div>
						<div class="panel-body">
							<div style="margin-bottom: 5px;">
								<strong>Note: </strong><span>You should choose images in size proportional to ratio of 850px &times; 315px</span>
							</div>
							<div class="fileinput fileinput-new" data-provides="fileinput" id="coverFileInput">
							  <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width:850px; height: 315px;" id="coverPreview"></div>
							  <div>
							    <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="..."></span>
							    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
							  </div>
							</div>
						</div>
					</div>
					<div class="row" style="text-align: center;">
						<a href="#" class="btn btn-primary" id="btnUploadPhoto" style="width: 100px;"><span class="glyphicon glyphicon-upload"></span>Update</a>
						<a href="#" class="btn btn-default" id="btnDiscardPhoto" style="width: 100px;"><span class="glyphicon glyphicon-pencil"></span>Discard</a>
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

<script type="text/javascript">
	$('#btnUploadPhoto').click(function(e) {
		e.preventDefault();

		var avatar = $('#avatarPreview img').attr('src');
		var cover = $('#coverPreview img').attr('src');

		var type = 'uploadimage';
		var course_id = '<?php echo $courses->get_ifa($alias); ?>';

		$.ajax({
			type 			: 'POST',
			url 			: 'processor/upload.php',
			data 			: {
				type  : type,
				course_id : course_id,
				avatar  : avatar,
				course_cover : cover
			},
			success : function(data) {
				if (data == 1) {
					alert('Updated successfully');
				} else {
					alert('There were errors while uploading. Please try again');
				}
			} 
		});

	});
</script>
<?php } else { 
	header('Location: courses.php');}?>
<?php 

 ?>
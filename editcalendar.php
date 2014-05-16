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
				<li><a href="editcourse.php?course_alias=<?php echo $course_data['course_alias']; ?>"><span class="glyphicon glyphicon-home"></span>Dashboard</a></li>
				<li><a href="editannouncement.php?course_alias=<?php echo $course_data['course_alias'];?>"><span class="glyphicon glyphicon-bullhorn"></span>Announcements</a></li>
				<li><a href="editphoto.php?course_alias=<?php echo $course_data['course_alias'];?>"><span class="glyphicon glyphicon-picture"></span>Photos</a></li>
				<li><a href="editsyllabus.php?course_alias=<?php echo $course_data['course_alias'];?>"><span class="glyphicon glyphicon-eye-open"></span>Syllabus</a></li>
				<li><a href="editcalendar.php?course_alias=<?php echo $course_data['course_alias'];?>"  class="active"><span class="glyphicon glyphicon-calendar"></span>Calendar</a></li>
				<li><a href="editlecture.php?course_alias=<?php echo $course_data['course_alias'];?>"><span class="glyphicon glyphicon-book"></span>Lectures</a></li>
				<li><a href="editexercise.php?course_alias=<?php echo $alias; ?>"><span class="glyphicon glyphicon-tasks"></span>Exercises</a></li>
				<li><a href="editmaterial.php?course_alias=<?php echo $course_data['course_alias'];?>"><span class="glyphicon glyphicon-print"></span>Course materials</a></li>
				<li><a href="editforum.php?course_alias=<?php echo $course_data['course_alias'];?>"><span class="glyphicon glyphicon-bookmark"></span>Discussions</a></li>
			</ul>
		</div> <!-- end of .sidebar -->

		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header"><?php echo $course_data['course_title']; ?></h1>
				<div class="page-segment" id="dashboard">
					<ol class="breadcrumb">
						<li><a href="editcourse.php?course_alias=<?php echo $course_data['course_alias'];?>"><span class="glyphicon glyphicon-home"></span>Dashboard</a></li>
                  <li><span class="glyphicon glyphicon-bullhorn"></span>Syllabus</li>
					</ol>
                    
                    <div class="row" style="padding-top: 0px; padding-left: 15px; padding-right: 15px;">
	                    	<a href="#" id="create_anno" class="btn btn-default"><span class="glyphicon glyphicon-star"></span>Create</a>
	                    	<a href="#" id="edit_anno" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span>Edit</a>
	                    	<a href="#" id="delete_anno" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span>Delete</a>
                    </div>
                    <?php foreach ($annos as $anno): ?>
                    <div class="row announcement-list">
                        <p>
                            <span><strong><?php echo strtoupper(date('F jS, Y', $anno['create_date']));?></strong></span>
                            <span class="pull-right label label-default"><?php echo $anno['valid_from'];?></span><br>
                            <span class="pull-right label label-default"><?php echo $anno['valid_to'];?></span>
                        </p>
                        <h4><strong><?php echo $anno['anno_title'];?></strong></h4>
                        <span><?php echo $anno['anno_content'];?></span>
                    </div>
                    <?php endforeach; ?>
				</div>

				
		</div>
	</div>
</div> <!-- end of .container -->

<?php } else { 
	header('Location: courses.php');}?>
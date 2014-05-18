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
	<div class="notifications bottom-right"></div>
	<div class="row">
		<div class="col-sm-3 col-md-2 sidebar">
			<ul class="nav nav-sidebar">
				<li><a href="editcourse.php?course_alias=<?php echo $course_data['course_alias']; ?>" ><span class="glyphicon glyphicon-home"></span>Dashboard</a></li>
				<li><a href="editannouncement.php?course_alias=<?php echo $course_data['course_alias'];?>" class="active"><span class="glyphicon glyphicon-bullhorn"></span>Announcements</a></li>
				<li><a href="editphoto.php?course_alias=<?php echo $course_data['course_alias'];?>"><span class="glyphicon glyphicon-picture"></span>Photos</a></li>
				<li><a href="#"><span class="glyphicon glyphicon-eye-open"></span>Syllabus</a></li>
				<li><a href="#"><span class="glyphicon glyphicon-calendar"></span>Calendar</a></li>
				<li><a href="#"><span class="glyphicon glyphicon-book"></span>Lectures</a></li>
				<li><a href="editexercise.php?course_alias=<?php echo $alias; ?>"><span class="glyphicon glyphicon-tasks"></span>Exercises</a></li>
				<li><a href="#"><span class="glyphicon glyphicon-print"></span>Course materials</a></li>
				<li><a href="#"><span class="glyphicon glyphicon-bookmark"></span>Discussions</a></li>
			</ul>
		</div> <!-- end of .sidebar -->

		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<h1 class="page-header"><?php echo $course_data['course_title']; ?></h1>
				<div class="page-segment" id="dashboard">
					<ol class="breadcrumb">
						<li><a href="editcourse.php?course_alias=<?php echo $course_data['course_alias'];?>"><span class="glyphicon glyphicon-home"></span>Dashboard</a></li>
                        <li><span class="glyphicon glyphicon-bullhorn"></span>Announcements</li>
					</ol>
                    
                    <div class="row" style="padding-top: 0px; padding-left: 15px; padding-right: 15px;">
	                    	<a href="#" id="create_anno" class="btn btn-default"><span class="glyphicon glyphicon-star"></span>Create</a>
	                    	<!-- <a href="#" id="edit_anno" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span>Edit</a>
	                    	<a href="#" id="delete_anno" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span>Delete</a> -->
                    </div>
                    <div class="row" style="padding-top: 0px; padding-left: 15px; padding-right: 15px;">
                    	<div class="panel panel-primary" id="panel-create-anno" >
                    		<div class="panel-heading">
                    			<h4 class="panel-title">Create new announcement</h4>
                    		</div>
                    		<div class="panel-body">
                    			<form class="form-horizontal" role="form">
									  <div class="form-group" id="inputTitleGroup">
									    <label class="col-sm-2 control-label">Title</label>
									    <div class="col-sm-10">
									      <input type="text" class="form-control" id="inputAnnoTitle" placeholder="Announcement title" required>
									    </div>
									  </div>
									  <div class="form-group" id="inputContentGroup">
									    <label class="col-sm-2 control-label">Content</label>
									    <div class="col-sm-10">
									      <textarea class="form-control" id="inputAnnoContent" placeholder="Announcement content goes here"></textarea>
									    </div>
									  </div>
							  			<div class="form-group" style="margin-left: 25px;" id="inputValidFromGroup">
							  				<div class="col-sm-6">
							  					<label class="col-sm-3 control-label">Valid from</label>
										    	<div class="col-sm-9">
										      	<input type="text" class="form-control" name="valid_from" id="valid_from" placeholder="Valid from"/>
										    	</div>
							  				</div>
									    	<div class="col-sm-6" id="inputValidToGroup">
							  					<label class="col-sm-3 control-label">Valid to</label>
										    	<div class="col-sm-9">
										      	<input type="text" class="form-control" name="valid_to" id="valid_to" placeholder="Valid to"/>
										    	</div>
							  				</div>
									  	</div>							  
									  <div class="col-md-6">
											<div class="form-group" style="margin-left: 25px;">
												<label class="col-sm-3 control-label" style="margin-right: 16px;">Type</label>
												<select class=" col-sm-9 form-control selectpicker" name="anno_type" id="anno_type" data-width="65%" required>
													<option value="1">Normal</option>
													<option value="2">Important</option>
													<option value="3">Urgent</option>
												</select>
											</div>
										</div>
									  <div class="form-group">
									    <div class="col-sm-offset-2 col-sm-10">
									      <button type="submit" class="btn btn-success" id="btnCreateAnnoForm">Create</button>
									      <button class="btn btn-default" id="btnDiscard">Discard</button>
									    </div>
									  </div>
									</form>
                    		</div>
                    	</div>
                    </div>
                    <?php foreach ($annos as $anno): ?>
                    <div class="row announcement-list">
                        <p>
                            <span><strong><?php echo strtoupper(date('F jS, Y', $anno['create_date']));?></strong></span>
                            <span class="pull-right label label-default"><?php echo $anno['valid_from'];?></span><br>
                            <span class="pull-right label label-default"><?php echo $anno['valid_to'];?></span>
                        </p>
                        <h4><strong><?php echo $anno['anno_title'];?></strong></h4>
                        <span class="anno_content"><?php echo $anno['anno_content'];?></span><br>
	                    	<a href="#" course-alias="<?php echo $course_data['course_alias']; ?>"id="d<?php echo $anno['anno_id'];?>" class="btn btn-sm pull-right" name="delete_anno"><span class="glyphicon glyphicon-trash"></span>Delete</a>
	                    	<a href="#" name="edit_anno" id="e<?php echo $anno['anno_id'];?>" class="btn btn-sm pull-right"><span class="glyphicon glyphicon-pencil"></span>Edit</a>   
                    </div>
                    <?php endforeach; ?>
				</div>

				
		</div>
	</div>
</div> <!-- end of .container -->
<script type="text/javascript">
	/* Loop through each announcement */
	$('[name="delete_anno"]').each(function(index) {
		$(this).click(function(e) {
			e.preventDefault();

			var id = $(this).attr('id').replace('d','');
			var course_alias = $(this).attr('course-alias');
			var type = 'announcement';
	
			$.ajax({
				type 		: 'POST',
				url      : 'processor/delete.php',
				data : {
					type  		 : type,
					course_alias : course_alias,
					id 			 : id
				},
				success : function(e) {
					$('.bottom-right').notify({
					    message: { text: 'Announcement has been successfully deleted' }
					}).show();
				}
			})
				.done(function(data) {
					console.log(data);
				});
				location.reload();
		})
	});

	$('#panel-create-anno').hide();

	$('#create_anno').click(function() {
		$('#panel-create-anno').toggle(500);
	})

	$('#valid_from').datepicker();
	$('#valid_to').datepicker();

	/* Clear form and don't create announcement */
	$('#btnDiscard').click(function(e) {
		e.preventDefault();
		$('#inputAnnoTitle').val('');
		$('#inputAnnoContent').val('');
		$('#valid_from').val('');
		$('#valid_to').val('');
		$('#panel-create-anno').hide(500);
	});

	/* Create announcement */
	$('#btnCreateAnnoForm').click(function(e) {
		e.preventDefault();
		$('.form-group').removeClass('has-error');
		$('.help-block').remove();
		var errors = false;

		if ($('#inputAnnoTitle').val() == '') {
			$('#inputTitleGroup').addClass('has-error');
			$('#inputTitleGroup').append('<div class="help-block col-sm-offset-2" style="padding-left: 15px;">The title cannot be empty</div>');
			errors = true; 
		}
		if ($('#valid_from').val() == '') {
			$('#inputValidFromGroup').addClass('has-error');
			$('#inputValidFromGroup').append('<div class="help-block col-sm-offset-2" style="padding-left: -20px;">Valid from field cannot be empty</div>');
			$errors = true;
		}

		if (errors == false) {
			var formData = {
				'type'				: 'announcement',
				'course_alias'    : '<?php echo $alias; ?>',
				'anno_title'      : $('#inputAnnoTitle').val(),
				'anno_content'    : $('#inputAnnoContent').val(),
				'valid_from' 		: $('#valid_from').val(),
				'valid_to'			: $('#valid_to').val(),
				'anno_type'			: $('#anno_type').val()
			};

			$.ajax({
				type 		: 'POST',
				url 		: 'processor/create.php',
				data 		: formData,
				// dataType : 'json',
				// contentType : 'application/json',
				success  : function() {
					location.reload();
				}
			});
		}
	});
</script>
<?php } else { 
	header('Location: courses.php');}?>
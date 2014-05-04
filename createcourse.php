<?php 
require 'core/init.php';
require 'navbar.php';

$general->logged_out_protect();
$status = '';

if (isset($_POST['submit'])) {

	if ($users->get_role($user_id) != 'Teacher') {
		$errors[] = 'Only teacher can create courses.';
	} else 

	if (empty($_POST['course_title']) || empty($_POST['course_code'])
		|| empty($_POST['course_alias']) || empty($_POST['course_cat'])
		|| empty($_POST['course_type'])) 
	{
		$errors[] = 'All fields are required';
	} else {

		# Validating user's input
		if ($courses->course_exists($_POST['course_alias'])) {
			$errors[] = 'The alias has already existed';
		} else if ($courses->course_exists($_POST['course_code'])) {
			$errors[] = 'The course code has already existed';
		}
		if ($_POST['course_type'] == 'period') {
			if (empty($_POST['start_date'])) {
				$errors[] = 'Course start date must be specified';
			} else if (empty($_POST['length'])) {
				$errors[] = 'Course length must be specified';
			}
		} # end if ($_POST['course_type'] == 'period')
	}

	if (empty($errors)) {
		
		$course_title = htmlentities($_POST['course_title']);
		$course_code  = htmlentities($_POST['course_code']);
		$course_alias = htmlentities($_POST['course_alias']);
		$cat_id		  = htmlentities(substr($_POST['course_cat'], 0, strpos($_POST['course_cat'], ' -'))); #, 
		$course_type  = ($_POST['course_type'] == 'sefls') ? 1 : 2;
		$start_date	  = htmlentities($_POST['start_date']);
		$length		  = htmlentities($_POST['length']);

		$courses->create_course($course_title, $course_code, $course_alias, $cat_id, $course_type, $start_date, $length, $user_id);

		if ($users->get_role($user_id) == 'Teacher') {
			header('Location: editcourse.php?course_alias=' . $course_alias);
		} else {
			header('Location: createcourse.php?success');
		}
		if (isset($_GET['success']) ) {
			$status = $course_alias . 'has been successfully created. Now you can edit the contents of the course';
		}
		exit();
	} # end if (empty($errors)) 

} # end if (isset($_POST['submit'])) 

?>

<div class="container" style="margin-top: 88px;">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading"><strong>Create a new course</strong></div>
			<div class="panel-body">
				<?php if (isset($status) === true && !empty($status)) { ?>
					<div class="alert alert-success"><?php echo $status; ?></div>
				<?php } ?>

				<?php if (isset($errors) === true && !empty($errors)) { ?>
					<div class="alert alert-danger">
						<span><strong>Errors:</strong></span><br>
						<?php foreach ($errors as $error) { ?>
							<p><?php echo $error; ?></p>
						<?php } ?>
					</div>
				<?php } ?>
				<div class="bs-callout bs-callout-info">
					<h4><strong>Please provide basic information of your course</strong></h4>
					<span>Note: Those information cannot be changed after the course is created. So, please be careful.</span>
				</div>

				<form role="form" method="post" action="createcourse.php">
					<div class="form-group">
						<label for="course_title"><strong>Course name</strong></label>
						<input type="text" name="course_title" placeholder="Course name" class="form-control" required />
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="course_code"><strong>Course code</strong></label>
								<input type="text" name="course_code" placeholder="Course code" class="form-control" required />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="course_alias"><strong>Course alias</strong></label>
								<input type="text" name="course_alias" placeholder="Course code" class="form-control" required />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label><strong>Catagories</strong></label>
								<select class="form-control selectpicker" name="course_cat" required>
									<?php $cats = $courses->get_cat();

									foreach ($cats as $cat) { ?>
									 	<option><?php echo $cat['cat_id'] . ' - '. $cat['cat_title']; ?></option>
									 <?php } ?>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label><strong>Course type</strong></label>
								<select class="form-control selectpicker" name="course_type" id="coursetype" required>
									<option value="sefls">Self-study</option>
									<option value="period">Period course</option>
								</select>
							</div>
						</div>
					</div> <!-- end .row-->

					<div class="row hidden-div" id="period">
						<div class="col-md-6">
							<div class="form-group">
								<label>Course start date</label>
								<input type="text" class="form-control" name="start_date" id = "start_date" placeholder="Course start date"/>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Course length</label>
								<input type="text" class="form-control" name="length" id="length" placeholder="Course length"/>
							</div>
						</div>
					</div> <!-- end .row-->

					<div class="form-group" style="margin-top: 15px;">
						<button type="submit" name="submit" class="btn btn-success">Create course</button>
					</div>
					</div>
				</form>
			</div>
		</div>	
	</div>
</div> <!-- end of .container-->
<?php 
require 'footer.php';
 ?>
  <script type="text/javascript">
          $(document).ready(function(e) {
              $('.selectpicker').selectpicker();
          });
      </script>
 <script  src="js/bootstrap-datepicker.js"></script>
 <script>
 $('#start_date').datepicker();
 $('#length').datepicker();
 </script>
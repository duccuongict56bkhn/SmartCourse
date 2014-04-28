<?php 
require 'core/init.php';
require 'navbar.php';

$general->logged_out_protect();
if (isset($_POST['submit'])) {

}
?>

<div class="container" style="margin-top: 88px;">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading"><strong>Create a new course</strong></div>
			<div class="panel-body">
				<div class="bs-callout bs-callout-info">
					<h4><strong>Please provide basic information of your course</strong></h4>
					<span>Note: Those information cannot be changed after the course is created. So, please be careful.</span>
				</div>

				<form role="form" method="post" action="">
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
								<select class="form-control selectpicker">
									<?php $cats = $courses->get_cat();

									foreach ($cats as $cat) { ?>
									 	<option><?php echo $cat['cat_title'];?></option>
									 <?php } ?>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label><strong>Course type</strong></label>
								<select class="form-control selectpicker">
									<option>Self-study</option>
									<option>Period course</option>
								</select>
							</div>
						</div>
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
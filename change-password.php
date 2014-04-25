<?php 
include_once 'navbar.php';
$general->logged_out_protect();
 ?>
<div class="container" style=" margin-top: 88px; width: 50%;">

	<?php 
	if (empty($_POST) === false) {
		if (empty($_POST['current_password']) || empty($_POST['password']) || empty(
			$_POST['password_again'])) {
			$errors[] = 'All fields are required';
		} else if ($bcrypt->verify($_POST['current_password'], $user['password']) === true) {
			if (trim($_POST['password']) != trim($_POST['password_again'])) {
				$errors[] = 'Confirmed password doesn\'t match';
			} else if (strlen($_POST['password']) < 6) {
				$errors[] = 'Your password must be at least 6 characters';
			} else if (strlen($_POST['password']) > 18) {
				$errors = 'Your password cannot be more than 18 characters long';
			}
		} else {
			$errors[] = 'Your current password is incorrect';
		}
	}
	?>


	<div class="panel panel-default" style="padding-bottom: 30px;">
		<div class="panel-heading">Register for <strong>Smartcourse</strong></div>
		<div class="panel-body">
			<div class="col-md-12">
				<?php if (isset($errors)) {
					echo "<div class=\"alert alert-danger\">";
					foreach ($errors as $error) {
						echo '<p><strong>Error: </strong>' . $error . '</p>';
					}
					echo "</div>";
				} else if (isset($status)) {
					echo "<div class=\"alert alert-success\">";
					echo '<p>' . $status . '</p>';
					echo "</div>";
				}?>
				<?php 
					if (isset($_GET['success']) === true && empty($_GET['success']) === true) {
						$status= 'Your password has been changed!';
					} else {
						if (empty($_POST) === false && empty($errors) === true) {
						 	$users->change_password($user['user_id'], $_POST['password']);
						 	header('Location: change-password.php?success');
						 } else if (!empty($errors)) {
						 	# code...
						 }?>
				<form class="form" role="form" method="post" action="">
                    <div class="form-group">
                       <label>Current password</label>
                       <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>

                    <div class="form-group">
                       <label>New password</label>
                       <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <div class="form-group">
                       <label>Confirm password</label>
                       <input type="password" class="form-control" id="password_again" name="password_again" required>
                    </div>

                    <div class="form-group col-xs-6" style="padding-left: 0 !important;">
                       <button type="submit" name="submit" class="btn btn-primary btn-block">Change password</button>
                    </div>
                 </form>
                 <?php } ?>
			</div>
	</div>
</div>	
</div>

<?php 

include_once 'footer.php'; ?>
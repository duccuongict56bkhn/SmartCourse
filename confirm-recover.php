<?php 
require 'core/init.php';
require 'navbar.php';
$general->logged_in_protect();
?>
<div class="container" style="margin-top: 25px;">
	<div class="panel panel-warning">
		<div class="panel-heading">
			<h1 class="panel-title"><strong>Recover your password</strong></h1>
		</div>
		<div class="panel-body">
			<?php 
				if (isset($_GET['success']) === true && empty($_GET['success']) === true) { ?>
				<h3>Thanks, please check your email to confirm your request for a password</h3>
			<?php } else {

				if (isset($_POST['email']) === true && empty($_POST['email']) === false) {
					if ($users->email_exists($_POST['email']) === true) {
						$users->confirm_recover($_POST['email']);

						header('Location: confirm-recover.php?success');
						exit();
					} else {
						echo "<div class=\"alerts alert-danger\"><strong>Error: </strong>Sorry that email doesn\'t exist.</div>";
					}
				}
				?>
				<h2>Recover Username/Password</h2>
				<form action="" class="form" role="form" method="post">
					<div class="form-group">
						<label>Enter your email</label>
						<input type="text" class="form-control" id="email" name="email" placeholder="Email" value="Recover" required>
					</div>
					<div class="form-group">
						<input type="submit" class="btn btn-primary" name="recover-btn" value="Go">
					</div>
				</form>
				<?php } ?>
		</div>
	</div>
</div>



<?php require 'footer.php' ?>
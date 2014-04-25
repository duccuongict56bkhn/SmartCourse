<?php 
	require 'core/init.php';
	require 'navbar.php';
 ?>
<div class="container" style="margin-top: 88px;">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h1 class="panel-title"><strong>Activate your account</strong></h1>
		</div>
		<div class="panel-body">
			
			<?php 
			if (isset($_GET['success']) ===true && empty($_GET['success']) === true) {
			 ?>
				<h2>Thank you, we've activated your account. You're free to log in!</h2>
			<?php 
			} else if (isset($_GET['email'], $_GET['email_code']) === true) {
				$email = trim($_GET['email']);
				$email_code = trim($_GET['email_code']);

				if ($users->email_exists($email) === false) {
					$errors[] = 'Sorry, we couldn\'t find that email address.';
				} else if ($users->activate($email, $email_code) === false) {
					$errors[] = 'Sorry, we couldn\'t activate your account.';
				}

				if (empty($errors) === false) {
					echo '<h3>' . implode('</h3><h3>', $errors) . '</h3>';
				} else {
					header('Location: activate.php?success');
					exit();
				}
			} else {
				header('Location: index.php');
				exit();
			 
			}
			?>
		</div>
	</div>
</div>

<?php 
	require 'footer.php';
 ?>
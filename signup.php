<?php 
require 'core/init.php';
require 'navbar.php';

$status = '';
 
# if form is submitted
if (isset($_POST['submit'])) {
 
	if(empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])){
 
		$errors[] = 'All fields are required.';
 
	}else{
        
        #validating user's input with functions that we will create next
        if ($users->user_exists($_POST['username']) === true) {
            $errors[] = 'That username already exists';
        }
        if(!ctype_alnum($_POST['username'])){
            $errors[] = 'Please enter a username with only alphabets and numbers';	
        }
        if (strlen($_POST['password']) <6){
            $errors[] = 'Your password must be at least 6 characters';
        } else if (strlen($_POST['password']) >18){
            $errors[] = 'Your password cannot be more than 18 characters long';
        }
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
            $errors[] = 'Please enter a valid email address';
        }else if ($users->email_exists($_POST['email']) === true) {
            $errors[] = 'That email already exists.';
        }
	}
	if(empty($errors) === true){
		
		$username 	= htmlentities($_POST['username']);
		$password 	= $_POST['password'];
		$email 		= htmlentities($_POST['email']);
 
		$users->register($username, $password, $email);// Calling the register function, which we will create soon.
		header('Location: signup.php?success');
		exit();
	}
}
 
if (isset($_GET['success']) && empty($_GET['success'])) {
  $status = 'Thank you for registering. Please check your email.';
} else {
	if (!empty($status)) {
		$status = 'There\'s something wrong. Please check again';
	}
}
?>

 <div class="container" style=" margin-top: 50px; width: 50%;">
		<div class="panel panel-default" style="padding-bottom: 30px;">
			<div class="panel-heading">Register for <strong>StudyHub</strong></div>
			<div class="panel-body">
				<div class="col-md-12">
					<?php if (isset($status) && !empty($status)) {
						echo "<div class=\"alert alert-info\">" . $status ."</div>";
						$status = '';
					}?>
					<form class="form" role="form" method="post" action="">
                         <div class="form-group">
                           <label for="username">Username</label>
                           <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php if (isset($_POST['username'])) echo htmlentities($_POST['username']); ?>" required>
                        </div>
                        <div class="form-group">
                           <label for="password">Password</label>
                           <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                           <label for="password">Password Confirm</label>
                           <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                           <label for="email">Email</label>
                           <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php if (isset($_POST['email'])) echo htmlentities($_POST['email']); ?>" required>
                        </div>
                    	<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" required>I agree to the <a href="terms.html">Terms of Services</a> and <a href="terms.html#hornor-code">Honor Code</a>
								</label>
							</div>
						</div>
                        <div class="form-group col-xs-6" style="padding-left: 0 !important;">
                           <button type="submit" name="submit" class="btn btn-primary btn-block">Sign up</button>
                        </div>
                     </form>
				</div>

			<?php 
				#if there are errors
				if(empty($errors) === false) {
					// echo "<div class=\"alert alert-danger\">
					// <strong>Error(s): </strong>" . $errors[] . "</div>";
					echo '<p>' . implode('</p><p>', $errors) . '</p>';
				}
			 ?>
		</div>
	</div>	
</div>
 <?php require_once 'footer.php'; ?>
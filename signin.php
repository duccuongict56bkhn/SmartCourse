<?php
require 'core/init.php';
require 'navbar.php';
$general->logged_in_protect();

if (empty($_POST) === false) {

   $username = trim($_POST['username']);
   $password = trim($_POST['password']);

   if (empty($username) === true || empty($password) === true) {
      $errors[] = 'Sorry, but we need your username and password.';
   } else if ($users->user_exists($username) === false) {
      $errors[] = 'Sorry that username doesn\'t exists.';
   } else if ($users->email_confirmed($username) === false) {
      $errors[] = 'Sorry, but you need to activate your account. 
                Please check your email.';
   } else {
      if (strlen($password) > 18) {
         $errors[] = 'The password should be less than 18 characters, without spacing.';
      }
      $login = $users->login($username, $password);
      if ($login === false) {
         $errors[] = 'Sorry, that username/password is not correct';
      }else {
         // To prevent state session attack
         session_regenerate_id(true);// destroying the old session id and creating a new one
         $_SESSION['user_id'] =  $login;
         header('Location: home.php');
         exit();
      }
   }
} 
?>

<div class="container" style=" margin-top: 88px; width:50%;">
   
<?php if (isset($errors) === true) {
         echo "<div class=\"alert fade-in alert-danger\">";
         echo '<p>' . implode('</p><p>', $errors) . '</p>';
         echo "</div>";
} ?>    
            
	<div class="panel panel-default" style="padding-bottom: 30px;">
		<div class="panel-heading">Sign in to <strong>Smartcourse</strong></div>
		<div class="panel-body">
      
			<div class="col-md-8">
					 <form class="form" role="form" method="post" action="signin.php" accept-charset="UTF-8" id="login-nav">
                     <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php if (isset($_POST['username'])) echo htmlentities($_POST['username']); ?>" required>
                     </div>
                     <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                     </div>
<!--                      <div class="checkbox">
                        <label>
                        <input type="checkbox"> Remember me
                        </label>
                     </div> -->
                     <div class="form-group" style="padding-left: 0px; width: 142px;">
                        <button type="submit" name="submit" class="btn btn-primary btn-block">Sign in</button>
                     </div>

                     <div class="form-group">
                        <a href="confirm-recover.php">Forgot your password?</a>
                     </div>
                  </form>
			</div>

			<div class="col-md-4" id="have-account">
				<h4>Dont' have account?</h4>
				<p>Please <a href="signup.php">Sign up</a></p>
			</div>

		</div>
	</div>
	</div>	
 <?php require_once 'footer.php'; ?>
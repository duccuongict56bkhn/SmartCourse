<?php 
require 'navbar.php';
$general->logged_in_protect();
?>
<div class="container" style="margin-top: 88px;">
	<div class="panel panel-primary col-md-8">
		<div class="panel-heading">
			<h1 class="panel-title"><strong>Recover your password</strong></h1>
		</div>
		<div class="panel-body">
			<?php
        if (isset($_GET['success']) === true && empty ($_GET['success']) === true) {
            ?>
            <h3>Thank you, we've send you a randomly generated password in your email.</h3>
            <?php
            
        } else if (isset ($_GET['email'], $_GET['generated_string']) === true) {
            
            $email		=trim($_GET['email']);
            $string	    =trim($_GET['generated_string']);	
            
            if ($users->email_exists($email) === false || $users->recover($email, $string) === false) {
                $errors[] = 'Sorry, something went wrong and we couldn\'t recover your password.';
            }
            
            if (empty($errors) === false) {    		
 
        		echo '<p>' . implode('</p><p>', $errors) . '</p>';
    			
            } else {
            	#redirect the user to recover.php?success if recover() function does not return false.
                header('Location: recover.php?success');
                exit();
            }
        
        } else {
            header('Location: index.php'); // If the required parameters are not there in the url. redirect to index.php
            exit();
        }
        ?>
		</div>
	</div>
</div>



<?php require 'footer.php' ?>
<?php 
require 'navbar.php';
$general->logged_out_protect();

if (isset($_GET['username']) && !empty($_GET['username'])) {
	
	$username = htmlentities($_GET['username']);

	if ($users->user_exists($username) === false) {
		header('Location: index.php');
		die();
	} else {
		$profile_data = array();
		$user_id = $users->fetch_info('user_id', 'username', $username);
		$profile_data = $users->userdata($user_id);
	}

 ?>

 <!doctype html>
	<html lang="en">
	<head>	
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="css/style.css" >
	 	<title><?php echo $username; ?></title>
	</head>
	<body>
	<div class="container" style="margin-top: 88px;">
	<div class="col-md-3 profile-container">
		<?php 
		if (!empty($profile_data['avatar'])) {
			?>
			<img src="<?php echo $profile_data['avatar'];?>" class="profile-avatar">
			<?php
		}
		 ?>
		 <div class="user-general-info">
		 	<div class="display-name">
		 		<?php 
		 		if (!empty($profile_data['display_name'])) {
		 		?>
		 			<h2><?php echo $profile_data['display_name'];?></h2>
		 		<?php } else {
				?>
					<h2><?php echo $profile_data['first_name'] . ' '. $profile_data['last_name'];?></h2>
				<?php
		 		}
		 		 ?>
		 		<h3><?php echo $profile_data['username'];?></h3>
		 	</div>
		 	<div class="user-display-bio">
		 		<?php 
	 			if ($profile_data['gender'] != 'Undisclosed') {
	 			?>
	 				<span><strong>Gender</strong>: <?php echo $profile_data['gender']?></span>
	 			<?php
	 			}
		 		 ?>
		 	</div>
		 </div>
		 <div id="edit-user-profile">
			 <a href="settings.php" class="btn btn-success">Edit your profile</a>
		 </div>
	</div>

	<div class="col-md-9 course-list">
		<div class="navigation-tab">
			<ul class="nav nav-tabs" id="navTab">
			  <li class="active"><a href="#myCourses" data-toggle="tab">My courses</a></li>
			  <li><a href="#myFriends" data-toggle="tab">My friends</a></li>
			  <li><a href="#myForumPosts" data-toggle="tab">My forum post</a></li>
			</ul>
			<div class="tab-content">
			  	<div class="tab-pane fade active" id="myCourses">
			  		<span>Hashing password is basically just running the password string that the user supplies through a 'process' in which the original password gets lost and instead we get a different string as an output(hashed password). This string still holds some essence of the original password, but you cannot get the original string back by de-crypting it(going backwards). However, if we were to run the same original password string again through the same process, we can compare the two hashed strings and verify whether they originated from the same string. In many hashing methods the two hashes would be the same, such as md5() or sha1(), but when you use bcrypt and also a randomly generated Salt, which we will discuss later, the hashes can be different.
	Now why is this done? This is done because if someone somehow breaks into your site's database and if the passwords are present just as they were entered, the attacker will have the passwords of all the users in the database and hence access to their accounts; even worse, many people use the same passwords across different sites and platforms. Now the 'process' that we used in the last part was sha1() which does not produce a very secure hash, instead we will change our code from last part and use bcrypt().
	The bcrypt method is not as straight forward as sha1() or many other methods and it is also slow, both of which are actually the major reasons as to why it is the best method to choose.
	Let's create a new file called bcrypt.php in the classes folder and create the class called Bcrypt().</span>
			  	</div>
			  	<div class="tab-pane fade " id="myFriends">
			  		<ul>
						<li>Friend 1</li>
						<li>Friend 2</li>
						<li>Friend 3</li>
					</ul>
			  	</div>
			  	<div class="tab-pane fade" id="myForumPosts">
			  		<span>This should show a list of posts in forum</span>
			  	</div>
			</div>
		</div>
	</div>

	<script>
		$('#navTab a').click(function (e) {
		  e.preventDefault()
		  $(this).tab('show')
		});
	</script>
</div>
	</body>
	</html>
	<?php  
}else{
	header('Location: index.php'); // redirect to index if there is no username in the Url
}
?>

<?php 
include 'footer.php'; ?>
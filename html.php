<?php 
require 'core/init.php';

	

 ?>
 <!DOCTYPE html>
<html lang="en">
<head>
	<title>StudyHub | HTML Editor></title>
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/prettify.css">
	<link rel="stylesheet" href="css/datepicker.css">
	<link rel="stylesheet" href="css/bootstrap-select/bootstrap-select.css">
	<link rel="shortcut icon" href="images/icon.ico">
	<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900' rel='stylesheet' type='text/css'>
	<script src="js/jquery-2.1.0.min.js"></script>
	 <script src="js/bootstrap.js"></script>
	 	<link rel="stylesheet" href="fonts/font-awesome/css/font-awesome.css">
 <script src="js/ajax.js"></script>
 <script src="js/prettify.js"></script>
 <script src="css/bootstrap-select/bootstrap-select.js"></script>
 <script src="js/bootstrap-datepicker.js"></script>


	<link rel="stylesheet" href="summernote/summernote.css">
	<link rel="stylesheet" href="summernote/summernote-bs3.css">
	 <script src="summernote/summernote.js"></script>
</head>
<body>
	<div class="container">
		<div class="col-lg-12">
			<div id="summernote"></div>
		</div>
		<button class="btn btn-primary" id="get_code">Get HTML code</button>
	</div>


	<div>
 <script>
 $(document).ready(function() {
  $('#summernote').summernote({
  	height: 480
  });
});
 </script>
 <script>
 	$('#get_code').click(function() {
 		var sHTML = $('#summernote').code();
 		alert(sHTML);
 		$.ajax({
 			type: "POST",
 			url: "html.php",
 			data: { htmlString: sHTML}
 		});
 	});
 </script>
</body>
</html>

<?php 
if (isset($_POST['htmlString'])) {
	$courses->insert_html($_POST['htmlString']);
}

 ?>
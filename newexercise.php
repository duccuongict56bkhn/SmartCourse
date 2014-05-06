<?php 
require 'core/init.php';
$general->logged_out_protect();
$alias = $_GET['course'];
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>New Exercise</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="css/prettify.css">
		<link rel="shortcut icon" href="images/icon.ico">
		<script src="js/jquery-2.1.0.min.js"></script>
	 	<script src="js/bootstrap.js"></script>
	 	<script src="js/prettify.js"></script>
	 	<link rel="stylesheet" type="text/css" href="fonts/font-awesome/css/font-awesome.css">
	 	<link rel="stylesheet" type="text/css" href="summernote/summernote.css">
	 	<link rel="stylesheet" type="text/css" href="summernote/summernote-bs3.css">
	 	<script type="text/javascript" src="summernote/summernote.js"></script>
		<link rel="stylesheet" type="text/css" href="css/bootstrap-select/bootstrap-select.css">
		<script src="css/bootstrap-select/bootstrap-select.js"></script>
	 	<style type="text/css">
	 	.form-title {
	 		padding-bottom: 10px;
	 		border-bottom: 1px solid #eee;
	 	}
	 	label {
	 		padding-right: 10px;
	 		display: inline;
	 	}
	 	.sp {
	 		margin-bottom: 0;
	 		margin-top: 5px; 	
	 	}

	 	.form-btn {
	 		padding-top: 10px;
	 	}
	 	.multiple {
	 		padding-bottom: 10px;
	 	}
	 	</style>
	</head>
	<body>
		<div class="container" style="width: 100%;">
			<h3 class="form-title">Create new exercises <span id="close-window" class="label label-danger pull-right">Close</span></h3>
			<form role="form" method="post">
				<div class="form-group sp">
					<div class="row">
						<div class="col-md-6">
						<label>Exercise title</label>
						<input type="text" class="form-control" name="exercise_title" id="exercise_title" placeholder="Exercise title"> 
					</div>
					<div class="col-md-6">
						<label>Unit</label><br>
							<?php $c_id = $courses->get_info('course_id', 'course_alias', $alias);
								   $v_us = $courses->get_distinct_unit($c_id);
							 ?>
							 <select class="selectpicker" data-width="100%" id="ex_unit">
								 <?php foreach ($v_us as $v_u): ?>
								 	<option value="<?php echo $v_u['unit_id'] ?>">L<?php echo $v_u['unit_id'] . ' - ' . $v_u['unit_name']; ?></option>
								 <?php endforeach ?>
							 </select>
					</div>
					</div>
				</div>
				<div class="form-group sp">
					<div class="row">
						<div class="col-md-6">
							<label>Exercise type</label><br>
							<select class="selectpicker" name="exercise_type" style="width: 100%">
								<option value="1">Multiple-choice exercise</option>
								<option value="2">Written exercise</option>
							</select>
						</div>
						<div class="col-md-3">
							<label>Score</label>
							<input type="text" class="form-control" name="score" id="score" placeholder="Exercise score" style="display: inline;"> 
						</div>
						<div class="col-md-3">
							<label>Maximum attempt</label>
							<input type="text" class="form-control" name="attempt_limit" id="attempt_limit" placeholder="Maximum attempt" style="display: inline;"> 
						</div>
					</div>
				</div>
				<div class="form-group sp">
					<label>Question</label>
					<div id="summernote"></div>
				</div>
				<div class="form-group sp" id="mul-answer">
					<label>Answers</label>
					<div class="input-group multiple">
					  <span class="input-group-addon">A</span>
					  <input type="text" class="form-control" name="multiple_one" id="multiple_one">
					</div>
					<div class="input-group multiple">
					  <span class="input-group-addon">B</span>
					  <input type="text" class="form-control" name="multiple_two" id="multiple_two">
					</div>
					<div class="input-group multiple">
					  <span class="input-group-addon">C</span>
					  <input type="text" class="form-control" name="multiple_three" id="multiple_three">
					</div>
					<div class="input-group multiple">
					  <span class="input-group-addon">D </span>
					  <input type="text" class="form-control" name="multiple_four" id="multiple_four">
					</div>
				</div>
				<div class="form-group sp">
					<label>Correct Answer</label>
					<select class="selectpicker" name="correct_answer" style="width: 100%"  data-style="btn-primary">
							<option value="A">A</option>
							<option value="B">B</option>
							<option value="C">C</option>
							<option value="D">D</option>
					</select>
				</div>
				<div class="form-group form-btn">
					<button type="button" name="create_exercise" id="create_exercise" class="btn btn-primary">Create</button>
					<button type="button" name="discard" id="discard" class="btn btn-default" id="discard">Discard</button>
				</div>
			</form>
		</div>
		<script type="text/javascript">
			$(document).ready(function() {
			  $('.selectpicker').selectpicker();
			});
		</script>
		<script type="text/javascript">
			$(document).ready(function() {
			  $('#summernote').summernote({
			  	height: 100,
			  	focus: true
			  });
			});
		</script>
		<script type="text/javascript">
			// $('#close-window').click(function() {
			// 	close();
			// });

			$('#create_exercise').click(function(e) {
				// Check for the required fill
				var ex_title     = $("#exercise_title").val();
				var ex_score     = $("#score").val();
				var ex_attempt   = $("#attempt_limit").val();
				var ex_question  = $("#summernote").val();
				var ex_one		 = $("#multi_one").val();
				$.ajax({
					url : 'newexercise.php',
					type : 'POST',
					// data : 'exercise_title='+ex_title+'&unit_id=3&question_type=2'+'&score='+ex_score+'&attempt_limit='+ex_attempt+'&question='+ex_question+'&multi_one='+ex_one,
					data : {
						exercise_title : ex_title,
						unit_id		   : 3,
						question_type  : 2,
						score 			: ex_score,
						attempt_limit	: ex_attempt,
						question 		: ex_question,
						multi_one 		: ex_one
					},
					success : function() {
						alert('Exercise is successfully created');
					}
				});
			});
		</script>
	</body>
</html>
<?php 
// if (isset($_POST['exercise_title']) 
//  // && !empty($_POST['exercise_title'])
// )
 // && !empty($_POST['unit_id'])
 // && isset($_POST['question_type']) 
 // && !empty($_POST['question_type'])
 // && isset($_POST['score']) 
 // && !empty($_POST['score'])
 // && isset($_POST['attempt_limit']) 
 // && !empty($_POST['attempt_limit'])
 // && isset($_POST['question']) 
 // && !empty($_POST['question']) 
 // && isset($_POST['multi_one']) 
 // && !empty($_POST['multi_one'])) 
{

	// echo $_POST['exercise_title'];
	// echo $_POST['unit_id'];
	$ex_id = 1 + $courses->get_max_exercise_id($c_id, $_POST['unit_id']);
	$courses->create_exercise($_POST['unit_id'],
									 $c_id,
									 $ex_id,
									 $_POST['exercise_title'],
									 $_POST['question_type'],
									 $_POST['score'],
									 $_POST['attempt_limit'],
									 $_POST['question'],
									 $_POST['multi_one'], '', '', '', '');
}
 ?>
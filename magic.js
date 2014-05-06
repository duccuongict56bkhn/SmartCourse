/*
 ********** 
 * Code to pass Form data to PHP 
 *
 * by DuccuongICT
 * last update: 06-May-2014
 */

$(document).ready(function() {
	// process the form
	$('#ex-form').submit(function(e) {
		// get the form data
		var formData = {
			'course'		 : $('#alias').text(),	
			'exercise_title' : $('#exercise_title').val(),
			'unit_id'		 : $('#ex_unit').val(),
			'question_type'	 : $('#question_type').val(),
			'score'			 : $('#score').val(),
			'attempt_limit'	 : $('#attempt_limit').val(),
			'question'		 : $('#summernote').code(),
			'multiple_one'   : $('#multiple_one').val(),
			'multiple_two'   : $('#multiple_two').val(),
			'multiple_three' : $('#multiple_three').val(),
			'multiple_four'  : $('#multiple_four').val(),
			'correct_answer' : $('#correct_answer').val()
		};

		// process the form
		$.ajax({
			type 	 : 'POST',
			url		 : 'process.php',
			data 	 : formData,
			dataType : 'json',
			encode	 : true
		})
			.done(function(data){
				console.log(data);
			});
		e.preventDefault();
	});
});
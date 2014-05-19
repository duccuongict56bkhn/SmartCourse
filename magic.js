
/*
 ********** 
 * Code to pass Form data to PHP 
 *
 * by DuccuongICT
 * last update: 06-May-2014
 */
$(document).ready(function () {
	
	// process the form
	$('#ex-form').submit(function (event) {
		// get the form data
		var formData = {
			'course'         : $('#alias').text(),	
            'exercise_title' : $('#exercise_title').val(),
			'unit_id'		 : $('#ex_unit').val(),
			'question_type'  : $('#question_type').val(),
			'score'          : $('#score').val(),
			'attempt_limit'	 : $('#attempt_limit').val(),
			'question'       : $('#summernote').code(),
			'multiple_one'   : $('#multiple_one').val(),
			'multiple_two'   : $('#multiple_two').val(),
			'multiple_three' : $('#multiple_three').val(),
			'multiple_four'  : $('#multiple_four').val(),
			'correct_answer' : $('#correct_answer').val()
		};

		// process the form
		$.ajax({
			type 	    : 'POST',
			url		 : 'process.php',
			data 	    : formData,
			dataType  : 'json'
			// encode	 : true
		})
			.done(function(data){
				console.log(data);

				// Clear error for correct form
				$('.form-group').removeClass('has-error');
				$('.help-block').remove();

				// Handle errors and validation
				if (!data.success) {
					// console.log('Da vao data.success');
					// exercise title errors
					if (data.errors.exercise_title) {
						$('#title_group').addClass('has-error');
						// console.log('Da vao data.success.exercise_title');
						$('#title_group').append('<div class="help-block">' + data.errors.exercise_title + '</div>');
					};
                    
                    // unit errors. Show users to create a unit before create exercise
                    if (data.errors.unit_id) {
                        $('#unit_group').addClass('has-error');
                        $('#unit_group').append('<div class="help-block">' + data.errors.unit_id + '</div>');
                    }
                    
					// score errors
					if (data.errors.score) {
						$('#score_group').addClass('has-error');
						$('#score_group').append('<div class="help-block">' + data.errors.score + '</div>');
					};

					// attempt_limit errors
					if (data.errors.attempt_limit) {
						$('#attempt_group').addClass('has-error');
						$('#attempt_group').append('<div class="help-block">' + data.errors.attempt_limit + '</div>');
					};

					// question errors
					if (data.errors.question) {
						$('#question_group').addClass('has-error');
						$('#question_group').append('<div class="help-block">' + data.errors.question + '</div>');
					};

				} else {
					$('#success_modal').modal();
					// // ALL GOOD! just show the success message!
					// $('#ex-form').append('<div class="alert alert-success">' + data.message + '</div>');

					// // usually after form submission, you'll want to redirect
					//window.location =; // redirect a user to another page
					// alert('success'); // for now we'll just alert the user
				}
			})
			.fail(function(data) {
				console.log(data);
			});
		event.preventDefault();
	});

	// disable some controls when question type is changed
	$('#question_type').change(function() {
		if ($('#question_type').val() == 2) 
		{
			$('#question_type').selectpicker('title', 'Written exercise');
			$('#multiple_one').attr('disabled', '');
			$('#multiple_two').attr('disabled', '');
			$('#multiple_three').attr('disabled', '');
			$('#multiple_four').attr('disabled', '');
			$('#correct_answer').attr('disabled', '');
		} else {
			$('#question_type').selectpicker('title', 'Multiple-choice exercise');
			$('#multiple_one').removeAttr('disabled');
			$('#multiple_two').removeAttr('disabled');
			$('#multiple_three').removeAttr('disabled');
			$('#multiple_four').removeAttr('disabled');
			$('#correct_answer').removeAttr('disabled');
		}

	});
    
    var height_diff = $(window).height() - $('body').height();
    if ( height_diff > 0 ) {
        $('.nice-footer').css( 'margin-top', height_diff);
    }
});
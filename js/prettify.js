/**
 * File: prettify.js
 * 
 * Description: Add some dynamic to this site using jQuery
 * Author: duccuongict
 **/

$(document).ready(function() {
    // Show the start_date and length in createcourse.php only when 
    // the course_type is period
	$('.hidden-div').hide();
	$('#coursetype').change(function() {
		$('.hidden-div').hide();       
		$('#'+$(this).val()).show();
	});
    
   $('.selectpicker').selectpicker();
   $('#start_date').datepicker();
});
$(document).ready(function() {
	$('.hidden-div').hide();
	$('#coursetype').change(function() {
		$('.hidden-div').hide();
		$('#'+$(this).val()).show();
	});
});
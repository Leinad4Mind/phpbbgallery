head.ready(function () {
(function($) { // Avoid conflicts with other libraries
	'use strict';
	
	function showLoading()
	{
    document.getElementById('contactpaypal').style.display = 'none';
		document.getElementById('processingpaypal').style.display = 'block';
		return false;
	}
	// Price toggler for the deposit page 
	$('.price-toggler').click(function(){
		$('.price-toggle').hide();
		$($(this).attr('data-price-id')).show();
		$('#submitBtn').prop('disabled', false);
		$('#step1').css('background-color', 'green');
		$('#step1').addClass("special");
		$('label:has(input:radio:checked)').addClass('active');
		$('label:has(input:radio:not(:checked))').removeClass('active');
	
		$('#step1').css('color', 'white');
	});

	$('#submitBtn').click(function(){
		$('#step2').css('background-color', 'green');
		$('#step2').addClass("special");

		$('#step2').css('color', 'white');
	});

	$('#donationvalue').on('input change', function() {
	  
	  var val = $('#donationvalue').val();
	  var rval = parseInt(val, 10) + 1;
	  $('#donationoutput').text(vals[val]+ '.00') ;
	  $('#amount').val(vals[val]);
	  $('#donationicons span').removeClass('selected');
	  $('#donationicons span:nth-of-type(' + rval + ')').addClass('selected');
	});

	$('#donationicons span').click(function() {
	  var val = $('#donationicons span').index(this) / 2;
	  $('#donationvalue').val(val);
	  $('#donationvalue').change();
	});
	
})(jQuery); // Avoid conflicts with other libraries
});
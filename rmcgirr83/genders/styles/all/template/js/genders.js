/**
*
* @package Genders
* @copyright (c) 2020 RMcGirr83
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

(function($) { // Avoid conflicts with other libraries
	'use strict';

	$("#user_gender").change(function () {
		var gender_id = $(this).val();
        $.ajax({
            url: AJAX_GENDER.replace(/[^\/]+$/, gender_id),
			dataType: 'text',
			success: function(data){
				var json = $.parseJSON(data);
				$('#gender_image').html('<i class="fa '+json.gender+'" style="font-size:18px"></i>').show();
			}
		});
	});
})(jQuery); // Avoid conflicts with other libraries

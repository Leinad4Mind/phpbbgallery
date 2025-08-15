; (function ($, window, document) {
	// do stuff here and use $, window and document safely
	// https://www.phpbb.com/community/viewtopic.php?p=13589106#p13589106
'use strict';
	
	$('#default_cuavatar').on('click', function() {
		if (this.value > 0)
		{
			$('input:radio[name="config[default_rgravatar]"][value="0"]').prop('checked',true);
	}});

	$('#default_rgravatar').on('click', function() {
		if (this.value > 0)
		{
			$('input:radio[name="config[default_cuavatar]"][value="0"]').prop('checked',true);
		}});

})(jQuery, window, document);
/**
 *
 * @package phpBB Extension - mChat Icons Menu
 * @copyright (c) 2016 kasimi - https://kasimi.net
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */

jQuery(function ($) {

	"use strict";

	var $container = $('.dropdown-container-mchat-message-icons');
	$container.on('click', 'a', function() {
		$container.removeClass('dropdown-visible');
		$(this).closest('.dropdown').toggle();
	});

	var registerDropdown = function($message) {
		var $trigger = $message.find('.dropdown-trigger:first');
		var $contents = $message.find('.dropdown');
		phpbb.registerDropdown($trigger, $contents, {});
	};

	$(mChat).on({
		mchat_add_message_animate_before: function(e, data) {
			registerDropdown(data.message);
		},
		mchat_edit_message_before: function(e, data) {
			registerDropdown(data.newMessage);
		}
	});
});

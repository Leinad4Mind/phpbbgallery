/**
 *
 * @package phpBB Extension - Group Rules
 * @copyright (c) 2017-2018 Leinad4Mind - https://leinad4mind.top/forum
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

jQuery(function($) {
	$('#acp_grouprules').on('click', '.grouprules-then-action-add', function(e) {
		e.preventDefault();
		var $children = $(this).closest('.grouprules-then').children();
		var $action = $children.first().clone();
		$action.find('select').each(function() {
			this.selectedIndex = 0;
		});
		$action.find('input[type="checkbox"]').each(function(i) {
			this.checked = false;
		});
		$action.hide().insertBefore($children.last()).slideDown(200);
	}).on('click', '.grouprules-then-action-delete', function(e) {
		e.preventDefault();
		var $container = $(this).closest('.grouprules-then-action');
		if ($container.siblings('.grouprules-then-action').length) {
			$container.slideUp(200, function() {
				$(this).remove();
			});
		}
	}).on('click', '.move-up', function(e) {
		e.preventDefault();
		var $container = $(this).closest('.move-container');
		$container.prev('.move-container').detach().insertAfter($container);
	}).on('click', '.move-down', function(e) {
		e.preventDefault();
		var $container = $(this).closest('.move-container');
		$container.next('.move-container').detach().insertBefore($container);
	}).on('submit', function() {
		$('.grouprules-then').each(function() {
			$(this).find('.grouprules-then-stop').each(function(i) {
				this.value = i;
			});
		});
	});
});

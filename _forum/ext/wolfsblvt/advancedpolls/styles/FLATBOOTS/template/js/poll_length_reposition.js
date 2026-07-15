/**
 *
 * Advanced Polls - Poll Length Reposition
 *
 * @copyright (c) 2015 javiexin ( www.exincastillos.es )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Javier Lopez (javiexin)
 */

$(document).ready(function () {
	var $pollLengthDl = $('label > #poll_length').closest('div');
	var $container = $("#ap_poll_length_container");
	var $content = $container.contents();

	$pollLengthDl.prev('div').remove();
	$pollLengthDl.replaceWith($content);
	$container.remove();
});

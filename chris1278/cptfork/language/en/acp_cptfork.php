<?php
/**
 *
 * CF Change Post Time
 *
 * @copyright (c) 2024 chris1278
 * @copyright (c) 2015 javiexin ( www.exincastillos.es )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Javier Lopez (javiexin)
 */


if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, [
	'CF_CPT_TITLE_EXPLAIN'		=> 'Here on the page you can set the limit setting. By default, entering a time format that is in the future is blocked. The reason for this is that if you change a post so that it has a future date, the post will always be marked as an unread post for users. Even if the user has read the post or if the user uses the "Mark all forums as read" option. The post will be shown as unread until the current date is later than that of the post. Therefore, this is not recommended. However, there can be problems with changing it in relation to time zones. Therefore, I have included some options here.',
	'CF_CPT_INFO_TITLE'			=> 'Explanation of the following option selection!',
	'CF_CPT_OPTION_1_EXPLAIN'	=> 'Here as usual. The date limit is simply determined and used using the PHP function <b>date(\'Y-m-d\')</b>. As was the case up to now.',
	'CF_CPT_OPTION_2_EXPLAIN'	=> 'This option takes into account the time zone the moderator has set.',
	'CF_CPT_OPTION_3_EXPLAIN'	=> 'The time zone of the forum is taken into account here, regardless of which time zone the moderator has set.',
	'CF_CPT_OPTION_4_EXPLAIN'	=> 'With this option, an additional day is simply increased using the standard PHP function <b>date(\'Y-m-d\')</b>.',
	'CF_CPT_OPTION_5_EXPLAIN'	=> 'This option disables the limitation completely. <b>Is</b> <b style="color: red">not </b> <b>recommended!</b>',
	'CF_CPT_NAME'				=> 'Option selection',
	'CF_CPT_OPTION'				=> 'Options',
	'CF_CPT_OPTION_EXPLAIN'		=> 'Here you can select the desired option.<br><br>Explanations can be found in the header of this page.<br><br><b>Default:</b> Option No. 1',
	'CF_CPT_OPTION_1'			=> 'Option Nr. 1',
	'CF_CPT_OPTION_2'			=> 'Option Nr. 2',
	'CF_CPT_OPTION_3'			=> 'Option Nr. 3',
	'CF_CPT_OPTION_4'			=> 'Option Nr. 4',
	'CF_CPT_OPTION_5'			=> 'Option Nr. 5',
	'CF_CPT_SETTING_SAVED'		=> 'The selected option was saved successfully!',
]);

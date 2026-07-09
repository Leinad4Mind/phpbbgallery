<?php
/**
*
* @package phpBB Extension - Form Creator
* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbireland.com
* @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

/**
* DO NOT CHANGE
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
	'CLOSE_FORM'				=> 'Cancel',
	'OPEN_FORM'					=> 'Form Mode',
	'OPEN_POST'					=> 'Post Mode',
	'FORM_MOD_PREVIEW'		 	=> 'Switch to preview keeping the current form data...',
	'FORM_MOD_SUBMIT'			=> 'Add the form data to message and post...',
	'OPEN_FORM_EXPLAIN'			=> 'Switch to Form Mode...',
	'REFRESHING_FORM'			=> 'The current selected Forum is',
	'REQUIRED'				 	=> 'You have not entered all the required elements!',
	'MANDATORY'					=> 'Items marked with the asterisk are mandatory.',

	'ERROR_MANDATORY'			=> 'The field %s is mandatory.',
	'ERROR_MIN_MAX_CHECKBOX'	=> 'You need to select between %d and %d items for %s.',
]);

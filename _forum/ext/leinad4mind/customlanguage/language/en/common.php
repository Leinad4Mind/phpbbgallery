<?php
/**
*
* @package Custom Language
* @version $Id$
* @copyright (c) 2015-2021 https://leinad4mind.top/forum
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
	$lang = array();
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
// Some characters you may want to copy&paste: ‚ ‘ ’ « » „ “ ” …

$lang = array_merge($lang, array(
	'NEW_PROJECT'						=> 'Share New Project',
	'MY_PROJECTS'						=> 'My Projects',
	'NEW_ORDER'							=> 'Create New Order',
	'HELP'								=> 'Help',
	'RULES'								=> 'Rules',
	'INVITATIONS'						=> 'Invitations',
	'SETTINGS_NOTIFICATION'				=> 'Notification Settings',
	'WROTE'								=> '',
	'POST_STORED_MOD'					=> 'Topic has been submitted successfully, but it will need to be approved by a moderator and moved afterwards before it is publicly viewable.',
	'NOTIFICATION_TOPIC_APPROVED'		=> '<strong>Topic approved, will be soon moved</strong>:',
	'FORCE_PASSWORD_EXPLAIN'			=> 'Before you may continue browsing the board you are required for security reasons to change your password.<br>Further information is available here once you have changed your password: <a style="color:white" href="https://goldtuganime.com/forum/seguranca">https://goldtuganime.com/forum/seguranca</a>',
));

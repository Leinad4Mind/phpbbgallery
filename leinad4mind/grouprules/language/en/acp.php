<?php

/**
 *
 * @package phpBB Extension - Group Rules
 * @copyright (c) 2017-2018 Leinad4Mind - https://leinad4mind.top/forum
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
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
// Some characters for use
// ’ » “ ” …

$lang = array_merge($lang, [
	'ACP_GROUPRULES_EXPLAIN'		=> 'This form lets you define which groups should be monitored for certain events and what actions to take for them. Note that making a group default, promoting and demoting only have an effect if the user is already in the specified group. Make sure you don’t define loops.',

	'ACP_GROUPRULES_RULES'			=> 'Rules',

	'ACP_GROUPRULES_ADD_RULE'		=> 'Add rule',
	'ACP_GROUPRULES_ADD_ACTION'		=> 'Add action',
	'ACP_GROUPRULES_RULE_REMOVED'	=> '<strong>Group Rules</strong> rule removed.',
	'ACP_GROUPRULES_ACTION_REMOVED'	=> '<strong>Group Rules</strong> action removed.',

	'ACP_GROUPRULES_RULE_WHEN'		=> 'When a user %1$s group %2$s, then',
	'ACP_GROUPRULES_RULE_THEN'		=> '%1$s group %2$s',

	'ACP_GROUPRULES_WHEN_ADD'		=> 'is added to',
	'ACP_GROUPRULES_WHEN_DEL'		=> 'is removed from',
	'ACP_GROUPRULES_WHEN_DEFAULT'	=> 'is made default in',
	'ACP_GROUPRULES_WHEN_PROMOTE'	=> 'is promoted in',
	'ACP_GROUPRULES_WHEN_DEMOTE'	=> 'is demoted in',

	'ACP_GROUPRULES_THEN_ADD'		=> 'add user to',
	'ACP_GROUPRULES_THEN_DEL'		=> 'remove user from',
	'ACP_GROUPRULES_THEN_DEFAULT'	=> 'make user default in',
	'ACP_GROUPRULES_THEN_PROMOTE'	=> 'promote user in',
	'ACP_GROUPRULES_THEN_DEMOTE'	=> 'demote user in',

	'ACP_GROUPRULES_STOP'			=> 'don’t trigger other rules',

	'ACP_GROUPRULES_SETTINGS_SAVED'	=> '<strong>Group Rules</strong> settings saved.',
]);


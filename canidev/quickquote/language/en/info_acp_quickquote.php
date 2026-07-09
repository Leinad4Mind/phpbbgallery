<?php
/**
 * [English [En]]
 * @package cBB QuickQuote
 * @version 1.0.5 08/04/2025
 *
 * @copyright (c) 2025 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

// DO NOT CHANGE
if(!defined('IN_PHPBB'))
{
	exit;
}

if(empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'ACP_CAT_QUICKQUOTE'			=> 'QuickQuote',
	'ACP_QUICKQUOTE_CONFIG'			=> 'Configuration',
	'ACP_QUICKQUOTE_CONFIG_EXPLAIN'	=> 'From here you can manage the main options of the extension.',
	
	'MAIN_OPTIONS'					=> 'Main options',
	'QUICKQUOTE_FLOATBTN'			=> 'Float button',
	'QUICKQUOTE_FLOATBTN_EXPLAIN'	=> 'If enabled, a button will appear at the bottom of all allowed pages showing the saved quotes.
		<br />Otherwise, a button will be displayed in the editor to insert the quotes.',
	'QUICKQUOTE_GROUPS'				=> 'Authorized groups',
	'QUICKQUOTE_GROUPS_EXPLAIN'		=> 'Define the groups that can use this extension.<br />
		You can select multiple groups by using the <em>Ctrl</em> key on your keyboard.<br /><br />
		<em>Apart from this parameter, the use of the extension will be conditioned by the permissions to publish messages.</em>',
	'QUICKQUOTE_REPLY_OVERWRITE'			=> 'Overwrite response text',
	'QUICKQUOTE_REPLY_OVERWRITE_EXPLAIN'	=> 'Decide if the text written in the quick reply will be replaced by using the <em>Reply</em> function.<br />
		If it is set to "No" the quote will be inserted at the end of the text.',
]);

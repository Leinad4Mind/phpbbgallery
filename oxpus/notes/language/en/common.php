<?php

/**
*
* @package phpBB Extension - Personal Notes
* @copyright (c) 2014 OXPUS - www.oxpus.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

/*
* [ english ] language file
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

$lang = array_merge($lang, array(
	'ACP_NOTES'				=> 'Config notes',
	'ACP_NOTES_SETTINGS'	=> 'Max. number of notes per user',
	'UCP_NOTES'				=> 'Notes',
	'UCP_NOTES_CONFIG'		=> 'Settings',

	'NOTES'			=> 'Notes',
	'POPUP_NOTES'	=> 'Display Personal Notes as Popup',
	'FILTER_NOTES'	=> '<strong>Filter mode</strong><br />Press the search button again or change the sort method to display all notes.',
	'NOTES_MEM'		=> 'Reminder',
	'NOTES_MEMTEXT'	=> '<strong>You have entered notes with a reminder.</strong><br />%sClick here to list these notes.%s<br />(Clicking will remove the reminder)',
	'NO_NOTES'		=> 'You currently have no notes',

	'NOTES_CONFIG_SUCCESSFULL'	=> 'The settings for the notes are saved successfully.<br /><br />%sClick here to return to the configuration%s',
	'NOTES_LOG_CONFIG'			=> 'Change number of notes per user',
));

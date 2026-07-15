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
	$lang = [];
}

$lang = array_merge($lang, [
	'ACP_NOTES'				=> 'Config notes',
	'ACP_NOTES_SETTINGS'	=> 'Max. number of notes per user',
	'UCP_NOTES'				=> 'Notes',
	'UCP_NOTES_CONFIG'		=> 'Settings',

	'NOTES'				=> 'Notes',
	'NEW_NOTE'			=> 'New note',
	'POST_NEW_NOTE'		=> 'Post a new note',
	'POPUP_NOTES'		=> 'Display Personal Notes as Popup',
	'SLIDE_NOTES'		=> 'Open notes as title list, display by clicking the title',
	'FILTER_NOTES'		=> '<strong>Filter mode</strong><br />Press the search button again or change the sort method to display all notes.',
	'NOTES_MEM'			=> 'Set a reminder',
	'NOTES_MEM_ENABLE'	=> 'Yes remind me!',
	'NOTES_MEM_TIME'	=> 'Set date and time',
	'NOTES_MEMTEXT'		=> '<strong>You have entered notes with a reminder.</strong><br />%sClick here to list these notes.%s<br />(Clicking will remove the reminder)',
	'NO_NOTES'			=> 'You currently have no notes',

	'NOTES_DISCLAIMER'  		=> '**Notes you see here cannot be seen by anyone else, including administrators and moderators. If you have any questions or concerns, please contact a Board Administrator.',
	'NOTES_DISCLAIMER_POPUP'	=> '**Notes you see here cannot be seen by anyone else, including administrators and moderators.',

	'NOTES_CONFIG_SUCCESSFULL'	=> 'The settings for the notes are saved successfully.',
	'NOTES_DELETE_CONFIRM'		=> 'Are you sure you want to delete this note?',
	'NOTES_LOG_CONFIG'			=> 'Change number of notes per user',
]);

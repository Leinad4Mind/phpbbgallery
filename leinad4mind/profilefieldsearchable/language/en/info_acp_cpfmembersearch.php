<?php

/**
 *
 * Profile Field Searchable. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
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

$lang = array_merge($lang, [
	'SEARCHABLE_BY'              		=> 'Searchable',
	'SEARCHABLE'	             		=> 'No',
	'UNSEARCHABLE'               		=> 'Yes',
	'PROFILE_FIELD_SEARCHABLE'   		=> 'Profile field successfully searchable.',
	'PROFILE_FIELD_UNSEARCHABLE' 		=> 'Profile field successfully unsearchable.',

	'LOG_PROFILE_FIELD_SEARCHABLE'		=> '<strong>Profile field searchable</strong><br />» %s',
	'LOG_PROFILE_FIELD_UNSEARCHABLE'	=> '<strong>Profile field unsearchable</strong><br />» %s',
]);

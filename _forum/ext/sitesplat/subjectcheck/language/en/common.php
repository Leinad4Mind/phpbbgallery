<?php
/**
 *
 * Subject Check. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2016, SiteSplat
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
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
	'SUBJECT_CHECK_SIMILAR_TOPIC'	=> array(
		1	=> 'The subject of your topic is similar to an existing topic. Please check it out and/or reply there instead of creating a new topic.',
		2	=> 'The subject of your topic is similar to existing topics. Please check them out and/or reply there instead of creating a new topic.',
	),
	'SUBJECT_CHECK_STRICT_TOPIC'	=> array(
		1	=> 'The subject of your topic is similar to an existing topic. Please reply to this instead of creating a new topic.',
		2	=> 'The subject of your topic is similar to existing topics. Please reply to the one that most closely matches your message instead of creating a new topic.',
	),

	// One of these two strings will be appended to the above strings, so they need a leading space or some other separator.
	'SUBJECT_CHECK_NEW_WINDOW'			=> ' (Links will open in a new window.)',
	'SUBJECT_CHECK_SAME_WINDOW'			=> ' (Links will <em>NOT</em> open in a new window.)',

	// AJAX
	'SUBJECT_CHECK_WORKING'				=> 'Checking for topics with similar titles...',
));

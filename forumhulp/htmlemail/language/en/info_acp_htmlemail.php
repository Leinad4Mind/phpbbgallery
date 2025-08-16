<?php
/**
*
* HTML email.
*
* @copyright (c) 2015 ForumHulp.com <http://forumhulp.com>
* @license GNU General Public License, version 2 (GPL-2.0)
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

$lang = array_merge($lang, array(
	'LOG_CORE_INSTALLED'		=> '<strong>ForumHulp Core installed succesfully</strong>',
	'LOG_CORE_DEINSTALLED'		=> '<strong>ForumHulp Core deinstalled succesfully</strong>',

	'LOG_CORE_NOT_REPLACED'		=> '<strong>ForumHulp Core didn\'t deinstalled succesfully</strong><br />Could not replaced file(s)<br />» %s',
	'LOG_CORE_NOT_UPDATED'		=> '<strong>ForumHulp Core didn\'t installed succesfully</strong><br />Could not update file(s)<br />» %s',
	'HTML_EMAIL_NOTICE'			=> '',

));

?>
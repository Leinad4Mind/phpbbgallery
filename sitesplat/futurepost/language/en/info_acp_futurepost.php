<?php
/**
*
* Future Posts
*
* @copyright (c) 2017 ForumHulp.com <http://forumhulp.com>
* @license Proprietary
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
	'LOG_FUTURE_POST_APROVED'	=> '<strong>Future post approved</strong><br />» %s',
	'FH_HELPER_NOTICE'			=> 'Forumhulp helper application does not exist!<br />Download <a href="https://github.com/ForumHulp/helper">forumhulp/helper</a> and copy the helper folder to your forumhulp extension folder.',
	'FUTUREPOSTS_NOTICE'		=> '<div class="phpinfo"><p class="entry">This extension isn\'t configurable, but don\'t forget to look at the permissions</p></div>',

));

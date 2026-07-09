<?php
/**
*
* @package PM Moderation
* @copyright (c) 2016 ForumHulp | 2025 Leinad4Mind
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
	'UCP_PM_MODERATION_INFO' => 'PM\'s can be read and/or deleted by an administrator</p>',
));

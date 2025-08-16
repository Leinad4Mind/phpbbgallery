<?php
/**
*
* @package Faulty logins
* @copyright (c) 2014 John Peskens (http://ForumHulp.com)
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
	'LOG_FAULTY_LOGINS'	=> '<strong>Faulty login</strong><br />» %1s » %2s<br />» %3s',
));

<?php
/**
 * Translated By : [Brazilian Portuguese [pt_br]]
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
	$lang = [];
}

$lang = array_merge($lang, array(
	'LOG_FAULTY_LOGINS'	=> '<strong>Login falhado</strong><br />» %1s » %2s<br />» %3s',
));

<?php

/**
*
* info_acp_dap [Russian]
*
* @package Double Account Preventer
* @copyright (c) 2014 www.phpbb-work.ru
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
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
	'ACL_A_CLEARDUPE'	=> 'Может очищать список клонов',
));

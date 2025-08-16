<?php
/**
*
* BBtracking
*
* @copyright (c) 2017, Sitesplat
* @license private
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
	'ACL_M_PRIMEPOSTREV_VIEW'		=> 'Can view post revisions',
	'ACL_M_PRIMEPOSTREV_DELETE'		=> 'Can delete post revisions',
	'ACL_M_PRIMEPOSTREV_RESTORE'	=> 'Can restore post revisions',
	'ACL_F_PRIMEPOSTREV_VIEW'		=> 'Can view own post\'s revisions',
	'ACL_F_PRIMEPOSTREV_DELETE'		=> 'Can delete own post\'s revisions',
	'ACL_F_PRIMEPOSTREV_RESTORE'	=> 'Can restore own post\'s revisions',
));

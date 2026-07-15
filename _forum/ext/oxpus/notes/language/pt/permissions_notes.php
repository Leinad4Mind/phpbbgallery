<?php

/**
*
* @package phpBB Extension - Personal notes
* @copyright (c) 2014 OXPUS - www.oxpus.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

/**
* Language pack for Extension permissions [English]
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

// Permissions
$lang = array_merge($lang, [
	'ACP_NOTES'		=> 'Notas',

	'ACL_A_NOTES'	=> 'Pode configurar notas pessoais',
	'ACL_U_NOTES'	=> 'Pode usar notas pessoais',
]);

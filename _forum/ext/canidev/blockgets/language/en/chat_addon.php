<?php
/** 
* acp_blockgets.php [English [En]]
*
* @package language cBB Blockgets
* @version v2.0.0 30/07/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

if(empty($lang['blocks']))
{
	$lang['blocks'] = array();
}

$lang['blocks'] = array_merge($lang['blocks'], array(
	'chat_title'	=> 'Chat',
	'chat_explain'	=> 'Allows you to use cBB Chat as a block in the columns.',
));

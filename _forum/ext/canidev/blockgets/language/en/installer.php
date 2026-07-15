<?php
/*
* [English [En]]
* @package cBB Blockgets
* @version v2.0.4 30/08/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

if(empty($lang) || !is_array($lang))
{
	$lang = array();
}

// Local Variables
$lang = array_merge($lang, array(
	'PORTAL'			=> 'Portal',
	'DOCK_MENU'			=> 'Dock menu',
	'MAIN_MENU'			=> 'Main Menu',
	'RECOMMENDED'		=> 'Recommended',

	'P_ADMIN'			=> 'Administration',
	'P_MAIN'			=> 'Main',
	'P_MCP'				=> 'Moderation Panel',
	'P_ACP'				=> 'Administration Panel',

	'PHPBB_TITLE'		=> 'phpBB official website',
	'XAMPP_TITLE'		=> 'Xampp',
	'SOURCEFORGE_TITLE'	=> 'Open source applications',

	'WELCOME_GUEST'		=> '[html]<div style="text-align:center; font-size:1.2em;"><a href="https://www.canidev.com"><span class="blg-image logo-img"></span></a><br /><strong><i>Forum equipped with cBB Blockgets</i><br /><br />Welcome to our forum!<br />Register to access all the content!.</strong></div>[/html]',
	'WELCOME_MEMBER'	=> '[html]<div style="text-align:center; font-size:1.2em;"><a href="https://www.canidev.com"><span class="blg-image logo-img"></span></a><br /><strong><i>Forum equipped with cBB Blockgets</i><br /><br />Welcome back to our forum {S_USERNAME}</strong></div>[/html]',	

	'CORE_INSTALL_ERROR'	=> 'You have not uploaded all the files from the installation package or you are trying to install an old package.<br />
		Please make sure to upload all the files (including the <em>core</em> folder) and use a package downloaded from the official website.',
));

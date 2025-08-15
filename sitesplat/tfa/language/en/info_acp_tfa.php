<?php
/**
*
* @package Two Factor Authentication
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
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

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

$lang = array_merge($lang, array(
	'TFA'							=> 'Two Factor Authentication',
	
	'TFA_SETTING'					=> 'Two Factor Authentication setting',
	'TFA_SETTING_EXPLAIN'			=> 'Select the Two Factor Authentication options',

	'TFA_DISABLED'					=> 'Two factor authentication disabled',
	'TFA_NOT_REQUIRED'				=> 'Do not require two factor authentication',
	'TFA_REQUIRED_FOR_ACP_LOGIN'	=> 'Require two factor authentication for the ACP login only',
	'TFA_REQUIRED_FOR_ADMIN'		=> 'Require two factor authentication for all administrators',
	'TFA_REQUIRED_FOR_MODERATOR'	=> 'Require two factor authentication for all moderators and administrators',
	'TFA_REQUIRED'					=> 'Require two factor authentication for all users',

    'TFA_NOTICE'		=> '<div class="phpinfo"><p>The settings for this extension are in <strong>%1$s » %2$s » %3$s</strong>.</p></div>',
	'SS_HELPER_NOTY'	=> 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
));

<?php
/**
*
* Badge Award extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
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
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'ACP_BADGE_MANAGE'			=> 'Manage Badge Award',
	'BADGE_TYPE_NOT_EXIST'		=> 'The Badge Award type `%1$s` does not exist.',
	'BADGE_NOTICE'				=> '<div class="phpinfo"><p>The Setting for this extension are in <strong>%1$s &#187; %2$s &#187; %3$s</strong>.<br /><strong>Note:</strong> PayPal donations, likeBB and many other supported Premium Extension rules are <strong>only</strong> available if these Premium extensions are enabled!</p></div>',
    'SS_HELPER_NOTY'	        => 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	'ERROR_BADGE_DISABLE'	    => 'You cannot disable BBawards because of other active BBawards related extensions:<br /><div class="phpinfo">» %s</div>',
	
	// Logs
	'ACP_BADGE_SAVED_LOG'		=> '<strong>Badge Award configuration was saved</strong>',
	'ACP_BADGE_ADD_LOG'			=> '<strong>Badge Award configuration added</strong>',
	'ACP_BADGE_DELETE_LOG'		=> '<strong>Badge Award configuration was deleted</strong>',
	'ACP_BADGE_IMG_DELETE_LOG'	=> '<strong>The Badge image was deleted</strong>',
	'ACP_BADGE_IMG_UPLOAD_LOG'	=> '<strong>A new Badge was uploaded</strong>',
));

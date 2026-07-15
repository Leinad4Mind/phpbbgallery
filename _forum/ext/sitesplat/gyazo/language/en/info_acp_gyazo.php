<?php
/**
*
* Gyazo - forum images uploader
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
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(
    'SS_HELPER_NOTY'	        => 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	'GYAZO_NOTICE'				=> '<div style="width:auto;margin:20px auto;"><p>The settings for this extension are in <strong>%1$s » %2$s » %3$s.</strong><br />Please note, You will need to register a Gyazo app to get the Token ID needed for this extension to work. <br />For creating a new App, go to <a href="https://gyazo.com/api" target="_blank">https://gyazo.com/api</a> and register it following the instruction provided. <br />Then use the Gyazo token ID under <strong>ACP > Postings > Attachment settings: Gyazo Client ID</strong></p></div>',
));
